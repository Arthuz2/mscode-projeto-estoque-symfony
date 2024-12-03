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

  public function execute(): array | Exception
  {
    $carrinhos = $this->carrinhoRepository->findAll();

    if (!$carrinhos) {
      return new NaoExistemCarrinhosException();
    }

    return $carrinhos;
  }
}
