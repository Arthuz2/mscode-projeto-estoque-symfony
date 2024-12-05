<?php

namespace App\Controller\Cliente;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CadastrarClienteController extends AbstractController
{
    #[Route('/cliente/cadastrar/cliente', name: 'app_cliente_cadastrar_cliente')]
    public function index(): Response
    {
        return $this->render('cliente/cadastrar_cliente/index.html.twig', [
            'controller_name' => 'CadastrarClienteController',
        ]);
    }
}
