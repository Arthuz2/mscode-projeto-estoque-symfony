<?php

namespace App\Service;

use App\Repository\CarrinhoRepository;
use App\Repository\ClienteRepository;
use App\Entity\StatusEnum;
use App\Entity\Carrinho;

class BuscarOuCriarCarrinhoService
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository
    )
    {
    }

    public function execute(int $id): Carrinho

    {
        $cliente = $this->clienteRepository->find($id);
        if(null === $cliente){
            throw new \Exception("cliente nao encontrado!!!");
        }
        
        if($this->carrinhoRepository->findOneBy(['cliente' => $cliente, "status" => StatusEnum::aguardandoPagamento])){
            throw new \Exception("nao pode acessar esse carrinho pois o estatus dele é aguardando pagamentoo!!!");
        }

        $carrinho = $this->carrinhoRepository->findOneBy(['cliente' => $cliente, 'status' => StatusEnum::aberto]);
        if (null === $carrinho) {
            $carrinho = new Carrinho($cliente);
            $this->carrinhoRepository->salvar($carrinho);
        }

       
     
        return $carrinho;
    }
}