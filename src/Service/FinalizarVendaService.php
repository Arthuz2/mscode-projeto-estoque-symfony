<?php 
namespace App\Service;

use App\Entity\Carrinho;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private EntityManagerInterface $em,
        private ClienteRepository $clienteRepository,
    ) {
    }

    public function execute(int $id): Carrinho
    {
    
        $cliente = $this->clienteRepository->find($id);
        $carrinho = $this->carrinhoRepository->findOneBy(["cliente" => $cliente]);
    
    
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
            $this->em->persist($produto);
        }

        $carrinho->setStatus(StatusEnum::aguardandoPagamento);

        $this->carrinhoRepository->salvar($carrinho);
        return $carrinho;
    }

}

