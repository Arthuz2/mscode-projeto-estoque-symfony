<?php

namespace App\Controller\Api\Carrinho;

use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;
use App\Repository\ClienteRepository;
use App\Service\DescartarCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DescartarCarrinhoController extends AbstractController
{
  #[Route('/api/carrinho/descartar/{id}', name: 'decartar_carrinho')]
  public function index(
    CarrinhoRepository $carrinhoRepository,
    DescartarCarrinhoService $descartarCarrinhoService,
    int $id,
  ): JsonResponse {
    $id = $carrinhoRepository->findOneBy(
      [
        'cliente' => [
          'id' => $id
        ],
        'status' => StatusEnum::aberto
      ]
    )->getId();
    try {
      $descartarCarrinhoService->execute($id);
      return new JsonResponse(['response' => 'Carrinho descartado com sucesso'], 200, [], false);
    } catch (\Throwable $e) {
      return $e instanceof \Exception
        ? new JsonResponse(['response' => $e->getMessage()], 200)
        : new JsonResponse(['response' => $e->getMessage()], 500);
    }
  }
}
