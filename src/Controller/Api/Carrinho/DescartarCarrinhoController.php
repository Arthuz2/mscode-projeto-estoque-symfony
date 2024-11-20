<?php

namespace App\Controller\Api\Carrinho;

use App\Service\DescartarCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DescartarCarrinhoController extends AbstractController
{
  #[Route('/api/carrinho/descartar/{id}', name: 'decartar_carrinho')]
  public function index(
    DescartarCarrinhoService $descartarCarrinhoService,
    int $id,
  ): JsonResponse {
    try {
      $descartarCarrinhoService->execute($id);
      return new JsonResponse(['response' => 'Carrinho descartado com sucesso'], 200, [], false);
    } catch (\Throwable $e) {
      return new JsonResponse(
        [
          'response' => 'Erro ao descartar o carrinho',
          'erro' => $e->getMessage()
        ], 500, [], false
      );
    }
  }
}
