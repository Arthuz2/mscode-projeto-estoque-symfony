<?php

namespace App\Service;

// src/Service/BuscarOuCriarCarrinhoService.php

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

        if ($this->carrinhoRepository->findOneBy(['cliente' => $cliente, 'status' => StatusEnum::aguardandoPagamento])) {
            throw new \Exception("Não pode acessar esse carrinho pois o status dele é aguardando pagamento!");
        }

        $carrinho = $this->carrinhoRepository->buscarUltimoCarrinhoPendente($cliente);
        if (null === $carrinho) {
            $usuario = $this->security->getUser();
            $carrinho = new Carrinho($cliente, $usuario);
            $this->carrinhoRepository->salvar($carrinho);
        }
<<<<<<< HEAD
=======
     
>>>>>>> c6d86bf (fazendo logica do js)
        return $carrinho;
    }
}
