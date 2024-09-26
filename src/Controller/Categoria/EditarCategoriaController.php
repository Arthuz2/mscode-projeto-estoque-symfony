<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarCategoriaController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/categorias/editar/{id}', name: 'editar_categoria_show', methods: 'GET')]
    public function index(int $id): Response
    {
        $categoria = new Categoria();
        $categoria = $this->categoriaRepository->findBy(['id' => $id]);
        $nomeCategoria =  $categoria[0]->getNome();

        return $this->render('app/categoria/cadastrar_editar.html.twig', [
            'headTitle' => '- Categorias',
            'inicioActive' => '',
            'vendasActive' => '',
            'produtosActive' => 'active',
            'cadastrar' => true,
            'title' => 'Editar',
            'nome' => $nomeCategoria,
            'editOrSave' => 'Atualizar',
        ]);
    }

    #[Route('/categorias/editar', name: 'editar_categoria_salvar', methods: 'GET')]
    public function salvar(Request $request): Response
    {
        $nomeCategoria = $request->request->get('nome');
        dd("auqi");
        return $this->redirectToRoute('listar_categorias');
    }
}
