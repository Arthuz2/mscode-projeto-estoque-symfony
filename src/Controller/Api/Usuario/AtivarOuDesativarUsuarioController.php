<?php

namespace App\Controller\Api\Usuario;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario/ativar', name: 'usuario_toggle')]
class AtivarOuDesativarUsuarioController extends AbstractController
{
    public function __construct(
        private UsuarioRepository $usuarioRepository
   ) {
    
   }
   
    #[Route('/verificar/ativar/{id}', name: '_verificar_ativar')]
    public function __invoke(int $id): RedirectResponse
    {
        $usuario = $this->usuarioRepository->find($id);

        if (!$usuario) {
            throw $this->createNotFoundException('usuario não encontrado.');
        }

        $message = $usuario->isAtivo()
            ? 'O usuario foi desativado.'
            : 'O usuario foi ativado.';

        $this->addFlash('success', $message);

        $this->usuarioRepository->toggleStatus($usuario);

        return $this->redirectToRoute('listar_usuarios');
    }
}
