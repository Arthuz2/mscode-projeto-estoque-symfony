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
    public function novaVenda(): Response
    {
        // Passa o carrinho para o template
        return $this->render('venda/novaVenda.html.twig');
    }
} 

?>