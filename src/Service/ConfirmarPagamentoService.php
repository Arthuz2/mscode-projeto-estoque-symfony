<?php

namespace App\Service;

use App\Entity\Carrinho;
use App\Entity\StatusEnum;
use App\Repository\CarrinhoRepository;
use Exception;

use function PHPUnit\Framework\throwException;

class ConfirmarPagamentoService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
    )
    {
    }

    public function execute(int $id): Carrinho
    {
        if($id === null){
            throw new Exception("Id nao informado");
        }

        $carrinho = $this->carrinhoRepository->findOneBy(['id' => $id]);
        $carrinho->setStatus(StatusEnum::finalizado);
        return $this->carrinhoRepository->salvar($carrinho);
    }
}