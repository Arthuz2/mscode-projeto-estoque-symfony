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
    ) {}

    #[Route('/produtos/cadastrar', name: 'cadastrar_produto_show', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('app/produto/cadastrar_editar.html.twig', [
            'headTitle' => '- Produtos',
            'active' => 'produtos',
            'title' => 'Novo',
            'cadastrar' => true,
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }

    #[Route('/produtos/cadastrar', name: 'cadastrar_produto_salvar', methods: 'POST')]
    public function salvar(Request $request): Response
    {
        list('nome' => $nome, 'quantidade' => $quantidade, 'valor' => $valor) = $request->request->all();
        if (strlen($nome) > 100) {
            $this->addFlash('danger', 'Nome deve ter no máximo 100 caracteres!');
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        $produtoExistente = $this->produtoRepository->findBy(['nome' => $nome]);
        if ($produtoExistente) {
            $this->addFlash('danger', "Produto com nome \"{$nome}\" já existe!");
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        if(preg_match('/[0-9]/', $nome) || empty(trim($nome))){
            $this->addFlash('danger', 'Nome invalido');
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        if($quantidade <= 0 || $quantidade == ''){
            $this->addFlash('danger', 'Quantidade invalida');
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        if($valor <= 0 || $valor == ''){
            $this->addFlash('danger', 'Valor invalido');
            return $this->redirectToRoute('cadastrar_produto_show');
        }

        $categoria = $this->categoriaRepository->findBy(['id' => $request->get('categoriaId')])[0];

        $produto = new Produto();
        $produto->setNome($nome);
        $produto->setDescricao($request->get('descricao'));
        $produto->setCategoriaId($categoria);
        $produto->setQuantidadeInicial($request->get('quantidade'));
        $produto->setQuantidadeDisponivel($request->get('quantidade'));
        $produto->setValor($request->get('valor'));

        $this->produtoRepository->salvar($produto);

        return $this->redirectToRoute('listar_produtos');
    }
}
