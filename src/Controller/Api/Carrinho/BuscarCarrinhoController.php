<?php

namespace App\Controller\Api\Carrinho;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\BuscarOuCriarCarrinhoService;



class BuscarCarrinhoController extends AbstractController
{
    #[Route("/api/buscar-ou-criar-carrinho/{clienteId}", name:"buscar_carrinho", methods:["GET"])]
    public function __invoke(
        $clienteId,
       BuscarOuCriarCarrinhoService $service,
    ): JsonResponse
    {
        try {
            return new JsonResponse(['carrinho' => $service->execute(id: $clienteId)]); 
        } catch (\Throwable $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()]
            );
        }
    }
}
