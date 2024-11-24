<?php 
namespace App\Service;

use App\Entity\Carrinho;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use App\Repository\ClienteRepository;
use App\Repository\ProdutoRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository,
        private ProdutoRepository $produtoRepository,
    ) {
    }

    public function execute(int $id): Carrinho
    {

        $cliente = $this->clienteRepository->find($id);
        $carrinho = $this->carrinhoRepository->findOneBy(["cliente" => $cliente, "status" => StatusEnum::aberto]);
    
        if ($carrinho->getItems()->isEmpty()) {
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }
        
        if ($carrinho->getStatus() !== StatusEnum::aberto) {
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está pendente.');
        }
   
        foreach ($carrinho->getItems() as $item) {
           $produto = $item->getProduto();

           if ($produto->getQuantidadeDisponivel() === 0) {
               throw new BadRequestHttpException('O produto ' . $produto->getNome() . ' está fora de estoque.');
            }


            $produtoAlterado = $produto->getQuantidadeDisponivel() - 1;
            $produto->setQuantidadeDisponivel($produtoAlterado);
            $this->produtoRepository->salvar($produto);
        }
        $carrinho->setStatus(StatusEnum::aguardandoPagamento);
        return $this->carrinhoRepository->salvar($carrinho);

    }
}

