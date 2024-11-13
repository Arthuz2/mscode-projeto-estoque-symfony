<?php 
namespace App\Service;

use App\Entity\Carrinho;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private EntityManagerInterface $em
    ) {
    }

    public function execute(Carrinho $carrinho): void
    {
        if ($carrinho->getItems()->isEmpty()) {
            throw new BadRequestHttpException('O carrinho nao contem produtos.');
        }

        if ($carrinho->getStatus() !== StatusEnum::aberto) { 
            throw new BadRequestHttpException('Nao e possivel finalizar um carrinho que nao esta pendente');
        }

        $carrinho->setStatus(StatusEnum::aguardandoPagamento);
        $this->carrinhoRepository->salvar($carrinho);
        
    }
}
