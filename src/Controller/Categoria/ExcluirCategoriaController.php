<?php

namespace App\Controller\Categoria;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExcluirCategoriaController extends AbstractController
{

    public function __construct(
        private CategoriaRepository $categoriaRepository
    ){}

    #[Route('/categoria/excluir/{id}', name: 'excluir_categoria')]
    public function index(int|string $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);
        
        $this->categoriaRepository->excluir($categoria);

        return $this->redirectToRoute('listar_categorias');
    }
}
