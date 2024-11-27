<?php

namespace App\Controller\Api\Carrinho;

use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;
use App\Service\DescartarCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DescartarCarrinhoController extends AbstractController
{
  #[Route('/api/carrinho/descartar/{clienteId}', name: 'decartar_carrinho')]
  public function index(
    CarrinhoRepository $carrinhoRepository,
    DescartarCarrinhoService $descartarCarrinhoService,
    int $clienteId,
  ): JsonResponse {
    $carrinhoId = $carrinhoRepository->findOneBy(
      [
        'cliente' => [
          'id' => $clienteId
        ],
        'status' => StatusEnum::aberto
      ]
    )->getId();
    try {
      $descartarCarrinhoService->execute($carrinhoId);
      return new JsonResponse(['response' => 'Carrinho descartado com sucesso']);
    } catch (\Throwable $e) {
      return new JsonResponse(['response' => $e->getMessage()], 500);
    }
  }
}
