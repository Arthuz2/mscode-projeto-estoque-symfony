<?php

namespace App\Controller\Venda;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListarVendasController extends AbstractController
{
    #[Route('/vendas', name: 'vendas')]
    public function index(
        
    ): Response
    {
        return $this->render('venda/listarVendas.html.twig');
    }
}
