<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'usuario_route_name')]
    public function index(): Response
    {
        return $this->render('usuario/cadastrar_usuario.html.twig');
    }
}
