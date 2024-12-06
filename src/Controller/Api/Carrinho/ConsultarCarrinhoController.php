<?php

namespace App\Controller\Api\Carrinho;

use App\Service\BuscarTodosCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ConsultarCarrinhoController extends AbstractController
{
  public function __construct(
    private BuscarTodosCarrinhoService $buscarTodosCarrinhoService,
  ){}

  #[Route('/api/carrinho', name: 'consultar_carrinho', methods: ['GET'])]
  public function index(): JsonResponse
  {
    try {
      $carrinhos = $this->buscarTodosCarrinhoService->execute();
      return new JsonResponse($carrinhos);
    }catch( \Throwable $e){
      return new JsonResponse(['error' => $e->getMessage()], 500);
    }
  }
}
