<?php 
namespace App\Service;

use App\Entity\Carrinho;
use App\Entity\Item;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use App\Repository\ClienteRepository;
use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository,
        private ProdutoRepository $produtoRepository,
        private ItemRepository $itemRepository,
    ) {
    }
    //verificar a logica amanha porque eu adicioni um produto mesmo que carrinho nao tem mas eu adicionei, ai fal oque nao tinha produto
    public function execute(int $clienteId, array $produtos): Carrinho
    {
        $cliente = $this->clienteRepository->find($clienteId);
        $carrinho = $this->carrinhoRepository->findOneBy(["cliente" => $cliente]);
      
        if ($carrinho->getItems()->isEmpty()) {
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }

        if ($carrinho->getStatus() !== StatusEnum::aberto) {
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está em aberto.');
        }

        foreach($produtos as $produtoData)
        {
            $produto = $this->produtoRepository->find($produtoData['id']);
            $quantidade = $produtoData['qt_disponivel'];

            if ($produto->getQuantidadeDisponivel() < $quantidade) {
                throw new BadRequestHttpException('O produto ' . $produto->getNome() . ' está fora de estoque ou não possui quantidade suficiente.');
            }

            $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() - $quantidade);
            $this->produtoRepository->salvar($produto);
        }
       
        $carrinho->setStatus(StatusEnum::aguardandoPagamento);
        return $this->carrinhoRepository->salvar($carrinho);
    } 
}

