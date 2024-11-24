<?php 

namespace App\Controller\Venda;

use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;
use App\Repository\ClienteRepository;
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
        FinalizarVendaService $finalizarVendaService,
    ): JsonResponse
    {
        $id = $request->request->get('cliente');
        try {
            $finalizarVendaService->execute( id: $id);
            return new JsonResponse([
                "message" => 'Carrinho alterado para aguardando pagamento.'
            ]);
        }catch (\Throwable $e) {
            return  new JsonResponse(['error' => $e->getMessage()]);
        }
    }
}



