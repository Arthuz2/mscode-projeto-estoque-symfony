<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CadastrarProdutoController extends AbstractController
{

    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository
    ){}

    #[Route('/produtos/cadastrar/', name: 'cadastrar_produto_show')]
    public function index(): Response
    {
        return $this->render('app/produto/cadastrar_editar.html.twig', [
            'headTitle' => '- Produtos',
            'inicioActive' => '',
            'vendasActive' => '',
            'produtosActive' => 'active',
            'title' => 'Novo',
            'cadastrar' => true,
            'produto' => '',
            'categorias' => $this->categoriaRepository->findAll()
        ]);
    }

    #[Route('categorias/cadastrar', name: 'cadastrar_produto_salvar', methods: 'POST')]
    public function salvar(Request $request): Response
    {
        $nomeProduto = $request->request->get('nome');
        if (strlen($nomeProduto) > 100) {
            $this->addFlash('danger', 'Nome deve ter no máximo 100 caracteres!');
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        $produtoExistente = $this->produtoRepository->findBy(['nome' => $nomeProduto]);
        if ($produtoExistente) {
            $this->addFlash('danger', "Produto com nome \"{$nomeProduto}\" já existe!");
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        $produto = new Produto();
        $produto->setNome($nomeProduto);

        $this->produtoRepository->salvar($produto);

        return $this->redirectToRoute('listar_produtos');
    }
}
