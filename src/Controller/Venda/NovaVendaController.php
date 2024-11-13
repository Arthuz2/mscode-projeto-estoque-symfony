<?php

namespace App\Controller\Venda;


use App\Repository\CarrinhoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NovaVendaController extends AbstractController
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
    ){}

    #[Route('/novaVenda', name: 'nova_venda')]
    public function novaVenda(): Response
    {
        $carrinhos = $this->carrinhoRepository->findAll();
        
        return $this->render('venda/novaVenda.html.twig', ["carrinhos" => $carrinhos]);
    }
}
