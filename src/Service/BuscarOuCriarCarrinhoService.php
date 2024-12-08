<?php

namespace App\Service;

use App\Repository\CarrinhoRepository;
use App\Repository\ClienteRepository;
use App\Entity\StatusEnum;
use App\Entity\Carrinho;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\SecurityBundle\Security;

class BuscarOuCriarCarrinhoService
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository,
        private UsuarioRepository $usuarioRepository,
        private Security $security
    )
    {
    }

    public function execute(int $id): Carrinho
    {
        $cliente = $this->clienteRepository->find($id);
        if (null === $cliente) {
            throw new \Exception("Cliente não encontrado!");
        }

        $carrinho = $this->carrinhoRepository->buscarUltimoCarrinhoPendente($cliente);
        
        if (null === $carrinho || $carrinho->getStatus() === StatusEnum::finalizado) {
            $usuario = $this->security->getUser();
            $carrinho = new Carrinho($cliente, $usuario);
            $this->carrinhoRepository->salvar($carrinho);
        }
        return $carrinho;
    }
}
