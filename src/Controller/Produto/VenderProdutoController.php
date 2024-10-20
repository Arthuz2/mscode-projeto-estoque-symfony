<?php

namespace App\Controller\Produto;

use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VenderProdutoController extends AbstractController
{

    public function __construct(
        private ProdutoRepository $produtoRepository,
    ) {}

    #[Route('/produto/vender/{id}', name: 'vender_produto')]
    public function index(int|string $id): Response
    {
        $produto = $this->produtoRepository->find($id);
        $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() - 1);

        if ($produto->getQuantidadeDisponivel() < 0) {
            $this->addFlash('danger', 'Não há mais produtos disponíveis para venda');
            return $this->redirectToRoute('listar_produtos');
        }

        $this->produtoRepository->getEntityManager()->flush();

        return $this->redirectToRoute('listar_produtos');
    }
}
