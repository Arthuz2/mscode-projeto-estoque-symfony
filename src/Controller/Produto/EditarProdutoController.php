<?php

namespace App\Controller\Produto;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarProdutoController extends AbstractController
{
    #[Route('/produto/editar/{id}', name: 'editar_produto_show')]
    public function index(int $id): Response
    {
        return $this->render('app/produto/cadastrar_editar.html.twig', [
            
        ]);
    }

    #[Route('/produto/editar/{id}', name: 'editar_produto_salvar')]
    public function salvar(int $id): Response
    {
        return $this->render('app/produto/cadastrar_editar.html.twig', [
            
        ]);
    }
}
