<?php

namespace App\Controller\Produto;

use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExcluirProdutoController extends AbstractController
{

    public function __construct(
        private ProdutoRepository $produtoRepository,
        private ItemRepository $itemRepository,
    ){}

    #[Route('/produto/excluir/{id}', name: 'excluir_produto')]
    public function index(int|string $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        $item = $this->itemRepository->findBy(['produto' => $id]);
        
        if($item){
            $this->addFlash('danger', 'Você não pode excluir um produto vinculado a um item, exclua-o item primeiro!');
            return $this->redirectToRoute('listar_produtos');
        }
    
        $this->produtoRepository->excluir($produto);

        $this->addFlash('success', 'Produto excluido com sucesso!');
        return $this->redirectToRoute('listar_produtos');
    }
}
