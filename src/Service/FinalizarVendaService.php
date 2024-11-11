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
        // Valida se o carrinho contém produtos
        if ($carrinho->getItems()->isEmpty()) { // Verifica se existem produtos
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }

        // Valida se o carrinho já foi finalizado
        if ($carrinho->getStatus() !== StatusEnum::aberto) { // Certifique-se de comparar com o tipo correto
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está pendente.');
        }

        // Altera o status para "aguardando pagamento"
        $carrinho->setStatus(StatusEnum::aguardandoPagamento); // Certifique-se 
        $this->carrinhoRepository->salvar($carrinho);
        
    }
}
