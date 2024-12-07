<?php

namespace App\Controller\Usuario;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListarUsuarioController extends AbstractController
{
    public function __construct(
        private UsuarioRepository $usuarioRepository
    ){}

    #[Route('/usuario/listar', name: 'listar_usuarios')]
    public function index(): Response
    {
        return $this->render('usuario/listar.html.twig', [
            'headTitle' => '- Usuarios',
            'active' => 'usuarios',
            'usuarios' => $this->usuarioRepository->findAll(),
        ]);
    }
}

