<?php 

namespace App\Controller\Venda;

use App\Service\FinalizarVendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FinalizarVendaController extends AbstractController
{
    #[Route("novaVenda/finalizarCarrinho", name: "finalizarCarrinho", methods:"POST")]
    public function finalizarVenda(
        Request $request,
        FinalizarVendaService $finalizarVendaService
    ): JsonResponse 
    {
        try
        {
            $data = json_decode($request->getContent(), true);
            $clienteId = $data["cliente"];
            $produtos = $data["produtos"];
            $finalizarVendaService->execute($clienteId, $produtos);
            return new JsonResponse([
                "message" => 'aguardando pagamento'
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }
}



