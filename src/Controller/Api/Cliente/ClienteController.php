<?php 

namespace App\Controller\Api\Cliente;

use App\Service\BuscarClientesAtivosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    #[Route("/api/clientes", name:"buscar_clientes")]
    public function index(
       BuscarClientesAtivosService $service,
    ): JsonResponse {
        try {
            return new JsonResponse($service->execute());
        } catch (\Throwable $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}