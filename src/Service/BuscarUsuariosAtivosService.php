<?php 

namespace App\Service;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;

class BuscarUsuariosAtivosService
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
    ) {
    }

    /** @return Usuario [] */ 
    public function execute(): array
    {
        return $this->usuarioRepository->findBy(['ativo' => true]);
    }
}
