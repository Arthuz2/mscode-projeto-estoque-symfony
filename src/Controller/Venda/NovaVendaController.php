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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NovaVendaController extends AbstractController
{
    #[Route('/novaVenda', name: 'nova_venda')]
    public function novaVenda( CarrinhoRepository $carrinhoRepository): Response
    {
        // Passa o carrinho para o template
        return $this->render('venda/novaVenda.html.twig');

    }
} 

?>