<?php

namespace App\Controller\Cliente;

use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListarClienteController extends AbstractController
{
    public function __construct(
        private ClienteRepository $clienteRepository
    ){}

    #[Route('/cliente/listar', name: 'listar_clientes')]
    public function index(): Response
    {
        return $this->render('cliente/listar.html.twig', [
            'headTitle' => '- clientes',
            'active' => 'clientes',
            'clientes' => $this->clienteRepository->findAll(),
        ]);
    }
}

