<?php

namespace App\Service;

use App\Repository\CarrinhoRepository;
use App\Repository\ClienteRepository;
use App\Entity\StatusEnum;
use App\Entity\Carrinho;
use App\Repository\UsuarioRepository;

class BuscarOuCriarCarrinhoService
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository,
        private UsuarioRepository $usuarioRepository,
    )
    {
    }

    public function execute(int $id): Carrinho

    {
        $cliente = $this->clienteRepository->find($id);
        if(null === $cliente){
            throw new \Exception("cliente nao encontrado!!!");
        }

        $carrinho = $this->carrinhoRepository->findOneBy(['cliente' => $cliente, 'status' => StatusEnum::aberto]);
        $usuario = $this->usuarioRepository->findAll();
       
       
     
        if (null === $carrinho) {
            $carrinho = new Carrinho($cliente);
            $this->carrinhoRepository->salvar($carrinho);
        }
        return $carrinho;
    }
}