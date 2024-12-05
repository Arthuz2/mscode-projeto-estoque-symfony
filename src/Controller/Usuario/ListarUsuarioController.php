<?php

namespace App\Controller\Usuario;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario/listar', name: 'listar_usuario')]
class ListarUsuarioController extends AbstractController
{
    public function __invoke(UsuarioRepository $usuarioRepository): Response
    {
        $usuarios = $usuarioRepository->findAll();

        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }
}
