<?php 

namespace App\Controller\Venda;
use App\Entity\Carrinho;
use App\Service\FinalizarVendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinalizarVendaController extends AbstractController
{
    #[Route("novaVenda/finalizarCarrinho/{carrinho}", name: "finalizarCarrinho", methods:"POST")]
    public function finalizarVenda(
        Carrinho $carrinho,
        FinalizarVendaService $finalizarVendaService
    ): Response
    {
        try {
            $finalizarVendaService->execute(carrinho: $carrinho);
            return new JsonResponse([
                "message" => 'Carrinho alterado para aguardando pagamento.'
            ]);

        }catch (\Throwable $e) {
            // Retorna uma resposta JSON em caso de erro
            return new JsonResponse(['error' => $e->getMessage()],$e->getCode());
        }
    }
}

