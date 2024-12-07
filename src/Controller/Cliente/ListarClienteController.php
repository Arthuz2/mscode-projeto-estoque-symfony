<?php

namespace App\Controller\Cliente;

use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListarClienteController extends AbstractController
{

    #[Route('/cliente/listar', name: 'listar_clientes')]
    public function index(ClienteRepository $clienteRepository): Response
    {
        return $this->render('cliente/listar.html.twig', [
            'headTitle' => '- clientes',
            'active' => 'clientes',
            'clientes' => $clienteRepository->findAll(),
        ]);
    }
}
