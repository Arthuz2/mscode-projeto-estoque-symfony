<?php 

namespace App\Controller\Venda;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowConfirmacaoPagamentoController extends AbstractController
{
    #[Route("/confirmarPagamentoShow", name:"confirmarPagamento")]
    public function __invoke():Response
    {
        return $this->render("venda/confirmaPagamento.html.twig");
    }
}