<?php 

namespace App\Controller\Venda;
use App\Repository\CarrinhoRepository;
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
        CarrinhoRepository $carrinhoRepository
    ): JsonResponse
    {
        $id = $request->request->get('cliente');
        try {
            $carrinho = $carrinhoRepository->findBy(['id' => $id])[0];
            $finalizarVendaService->execute(carrinho: $carrinho);
            return new JsonResponse([
                "message" => 'Carrinho alterado para aguardando pagamento.'
            ]);

        }catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }
    }
}

