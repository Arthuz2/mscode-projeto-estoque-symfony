<?php
namespace App\Controller\Api\Pagamento;

use App\Entity\Carrinho;
use App\Entity\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PagamentoController extends AbstractController {
    #[Route('/api/cart/{id}/pay', name:'pay_cart', methods: 'POST')]
    public function pagarCarrinho(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $carrinho = $entityManager->getRepository(Carrinho::class)->find($id);

        if (!$carrinho) {
            return new JsonResponse(['error' => 'Carrinho não encontrado.'], 404);
        }

        if ($carrinho->isPaid()) {
            return new JsonResponse(['error' => 'O carrinho já foi pago.'], 400);
        }

        if ($carrinho->getStatus() !== StatusEnum::aguardandoPagamento) {
            return new JsonResponse(['error' => 'O carrinho não está no status correto para pagamento.'], 400);
        }

        $carrinho->setStatus(StatusEnum::finalizado);
        $carrinho->updateFinalizadoEm();
        $entityManager->persist($carrinho);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Pagamento realizado com sucesso!', 'cart_id' => $id]);
    }
}
