<?php 
namespace App\Controller\Api\Carrinho;

use App\Service\BuscarCarrinhoAguardandoPagamentoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BuscarCarrinhoAguardandoPagamentoController extends AbstractController
{
    #[Route("/api/buscarCarrinhoAguardandoPagamento")]
    public function __invoke(
        BuscarCarrinhoAguardandoPagamentoService $buscarCarrinhoAguardandoPagamentoService,
    ):JsonResponse
    {
        try{
            return new JsonResponse($buscarCarrinhoAguardandoPagamentoService->execute());
        }catch(\Throwable $e){
            return new JsonResponse(
                ['error' => $e->getMessage()],
                500,
            );
        }
    }
}