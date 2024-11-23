<?php

namespace App\Service;

use App\Controller\Exception\CarrinhoJaDescartadoException;
use App\Entity\Carrinho;
use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;

class DescartarCarrinhoService
{
  public function __construct(
    private CarrinhoRepository $carrinhoRepository
  ) {}

  public function execute(int|Carrinho $carrinho): void
  {
    $carrinho = $this->carrinhoRepository->find($carrinho);

    if ($carrinho->getStatus() === StatusEnum::descartado) {
      throw new CarrinhoJaDescartadoException('carrinho ja foi descartado', 500);
    }

    $dataAtual = new \DateTime();
    if (!$carrinho->getCriadoEm()->format('d/m/Y') === $dataAtual->format('d/m/Y') && $carrinho->getStatus() === StatusEnum::aberto) {
      $carrinho->setStatus(StatusEnum::descartado);
      $carrinho->updateAtualizadoEm();
      $this->carrinhoRepository->salvar($carrinho);
    }

    $carrinho->setStatus(StatusEnum::descartado);
    $carrinho->updateAtualizadoEm();
    $carrinho->updateFinalizadoEm();
    $this->carrinhoRepository->salvar($carrinho);
  }
}
