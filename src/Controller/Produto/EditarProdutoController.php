<?php

namespace App\Controller\Produto;

use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarProdutoController extends AbstractController
{

    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository,
    ){}

    #[Route('/produto/editar/{id}', name: 'editar_produto_show')]
    public function index(int $id): Response
    {
        $produto = $this->produtoRepository->findBy(['id' => $id])[0];
        $categorias = $this->categoriaRepository->findAll();

        return $this->render('app/produto/cadastrar_editar.html.twig', [
            'headTitle' => '- Produtos',
            'active' => 'produtos',
            'title' => 'Editar',
            'cadastrar' => false,
            'produto' => $produto,
            'categorias' => $categorias,
        ]);
    }

    #[Route('/produto/editar/salvar/{id}', name: 'editar_produto_salvar')]
    public function editar(Request $request, int $id): Response
    {
        list('nome' => $nome, 'valor' => $valor) = $request->request->all();
        if (strlen($nome) > 100) {
            $this->addFlash('danger', 'Nome deve ter no máximo 100 caracteres!');
            return $this->redirectToRoute('editar_produto_show',  ['id' => $id]);
        }

        $produtoExiste = $this->produtoRepository->findOneBy(['nome' => $nome]);
        if ($produtoExiste && $produtoExiste->getId() != $id) {
            $this->addFlash('danger', 'Já Existe um produto com este nome!');
            $this->redirectToRoute('editar_produto_show', ['id' => $id]);
        }

        if(preg_match('/[0-9]/', $nome) || empty(trim($nome))){
            $this->addFlash('danger', 'Nome invalido');
            return $this->redirectToRoute('editar_produto_show', ['id' => $id]);
        }

        if($valor <= 0 || $valor == ''){
            $this->addFlash('danger', 'Valor invalido');
            return $this->redirectToRoute('editar_produto_show', ['id' => $id]);
        }

        $categoria = $this->categoriaRepository->findBy(['id' => $request->get('categoriaId')])[0];
        
        $produto = $this->produtoRepository->find($id);

        $produto->setNome($nome);
        $produto->setDescricao($request->get('descricao'));
        $produto->setCategoriaId($categoria);
        $produto->setValor($valor);

        $this->produtoRepository->getEntityManager()->flush();

        return $this->redirectToRoute('listar_produtos');
    }
}
