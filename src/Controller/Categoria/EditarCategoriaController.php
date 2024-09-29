<?php

namespace App\Controller\Categoria;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {}

    #[Route('/categoria/editar/{id}', name: 'editar_categoria_show', methods: 'GET')]
    public function index(int $id): Response
    {
        $categoria = $this->categoriaRepository->find($id);

        return $this->render('app/categoria/cadastrar_editar.html.twig', [
            'headTitle' => '- Categorias',
            'active' => 'produtos',
            'cadastrar' => false,
            'title' => 'Editar',
            'categoria' => $categoria,
        ]);
    }

    #[Route('/categoria/editar/salvar/{id}', name: 'editar_categoria_salvar')]
    public function editar(Request $request, int $id): Response
    {
        $nomeCategoria = $request->request->get('nome');

        $categoria = $this->categoriaRepository->find($id);

        $categoria->setNome($nomeCategoria);

        $this->categoriaRepository->getEntityManager()->flush();

        return $this->redirectToRoute('listar_categorias');
    }
}
