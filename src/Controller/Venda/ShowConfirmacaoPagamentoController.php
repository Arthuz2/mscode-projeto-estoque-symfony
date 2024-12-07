<?php 

namespace App\Controller\Venda;

use App\Entity\Carrinho;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowConfirmacaoPagamentoController extends AbstractController
{
    public const ROUTE_NAME = 'confirmarPagamentoShow';

    #[Route("/confirmarPagamentoShow/{carrinho}", name: self::ROUTE_NAME)]
    public function __invoke(
        Carrinho $carrinho
    ): Response {
        return $this->render("venda/confirmaPagamento.html.twig",compact('carrinho'));
    }
}