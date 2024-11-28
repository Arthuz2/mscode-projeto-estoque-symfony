<?php

namespace App\Service;

use App\Controller\Exception\CarrinhoJaDescartadoException;
use App\Controller\Exception\CarrinhoNaoPodeSerDescartadoException;
use App\Entity\Carrinho;
use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;

class DescartarCarrinhoService
{
  public function __construct(
    private CarrinhoRepository $carrinhoRepository,
  ) {}

  public function execute(int|Carrinho $carrinho): void
  {
    $carrinho = $this->carrinhoRepository->find($carrinho);

    if ($carrinho->getStatus() === StatusEnum::descartado) {
      throw new CarrinhoJaDescartadoException();
    }

    $dataAtual = new \DateTime();
    if ($carrinho->getCriadoEm()->format('d/m/Y') !== $dataAtual->format('d/m/Y') && $carrinho->isAberto()) {
      $carrinho->descartar();
      $this->carrinhoRepository->salvar($carrinho);
      return ;
    }

    throw new CarrinhoNaoPodeSerDescartadoException();
  }
}
