<?php

namespace App\Controller\Api\Carrinho;

use App\Service\DescartarCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DescartarCarrinhoController extends AbstractController
{
  #[Route('/api/carrinho/descartar', name:'decartar_carrinho')]
  public function index(
    DescartarCarrinhoService $descartarCarrinhoService
  ): JsonResponse
  {
    
  }
}
