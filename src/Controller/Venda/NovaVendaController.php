<?php 

namespace App\Controller\Venda;


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
        //conserta amanha
        //erro na tela quando nao tem nenhum carrinho em aberto,so aparece na tela se tiver carrinho aberto
        $carrinho = $carrinhoRepository->findOneBy(['status' => "em aberto"]);

        // Passa o carrinho para o template
        return $this->render('venda/novaVenda.html.twig', [
            'produto' => $produto,
            'carrinho' => $carrinho,
        ]);
    }
} 

?>