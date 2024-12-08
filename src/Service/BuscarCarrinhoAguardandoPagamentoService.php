<?php

namespace App\Service;

use App\Entity\Carrinho;
use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;

class BuscarCarrinhoAguardandoPagamentoService
{
    public function __construct(
        Private CarrinhoRepository $carrinhoRepository
    )
    {
    }
    
    /** @return Carrinho[] */
    public function execute(): array
    {
       return  $this->carrinhoRepository->findBy(["status" => StatusEnum::aguardandoPagamento]);
    }
}
