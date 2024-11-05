<?php 

namespace App\Controller\Venda;

/* use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; */

/* class NovaVendaController extends AbstractController
{

    #[Route("/novaVenda", name:"novaVenda")]
    public function show():Response
    {
        return $this->render("venda/novaVenda.html.twig");
    }
}  */

use App\Repository\CarrinhoRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NovaVendaController extends AbstractController
{
    #[Route('/novaVenda', name: 'nova_venda')]
    public function novaVenda( ProdutoRepository $produtoRepository, CarrinhoRepository $carrinhoRepository): Response
    {
      
        $produto = $produtoRepository->findAll();
        $carrinho = $carrinhoRepository->findOneBy(['id' => 1]);

        // Passa o carrinho para o template
        return $this->render('venda/novaVenda.html.twig', [
            'produto' => $produto,
            'carrinho' => $carrinho,
        ]);
    }
} 

?>