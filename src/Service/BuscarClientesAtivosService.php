<?php 

namespace App\Service;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;

class BuscarClientesAtivosService
{
    public function __construct(
        private ClienteRepository $clienteRepository,
    ) {
    }

    /** @return Cliente[] */ 
    public function execute(): array
    {
        return $this->clienteRepository->findBy(['ativo' => true]);
    }
}
