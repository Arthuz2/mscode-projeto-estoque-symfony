<?php

namespace App\Service;

use App\Controller\Exception\NaoExistemCarrinhosException;
use App\Repository\CarrinhoRepository;
use Exception;

class BuscarTodosCarrinhoService
{
  public function __construct(
    private CarrinhoRepository $carrinhoRepository,
  ) {}

  /** @return Carrinho[] */
  public function execute(): array
  {
    $carrinhos = $this->carrinhoRepository->findAll();
    if (!$carrinhos) {
      throw new NaoExistemCarrinhosException();
    }
    return $carrinhos;
  }
}
