<?php 
namespace App\Service;

use App\Entity\Carrinho;
use App\Entity\Item;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private EntityManagerInterface $em,
        private Item $item,
       
    ) {
    }

    public function execute(Carrinho $carrinho): void
    {
        // Valida se o carrinho contém produtos
        if ($carrinho->getItems()->isEmpty()) { // Verifica se existem produtos
            dd($carrinho);
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }

        // Valida se o carrinho já foi finalizado
        if ($carrinho->getStatus() !== StatusEnum::aberto) { // Certifique-se de comparar com o tipo correto
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está pendente.');
        }

        //lugar do codigo
        if($this->item->getEstoque() === 0 ){
            throw new BadRequestHttpException('nao temos estoque.');
        } 

        $this->item->getEstoque() - 1;
        $this->em->flush();
        $this->em->persist($this->item);
       
        // Altera o status para "aguardando pagamento"
        $carrinho->setStatus(StatusEnum::aguardandoPagamento); // Certifique-se 
        $this->carrinhoRepository->salvar($carrinho);
        
    }
}

