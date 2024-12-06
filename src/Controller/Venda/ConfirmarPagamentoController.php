<?php

namespace App\Controller\Venda;

use App\Service\ConfirmarPagamentoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ConfirmarPagamentoController extends AbstractController
{

    #[Route("/confirmarPagamento/{id}", name:"confirmarPagamento")]
    public function __invoke(
        int $id ,
        ConfirmarPagamentoService $confirmarPagamentoService
    ): Response
    {
        try{
            $confirmarPagamentoService->execute(id: $id);
            return $this->redirectToRoute("nova_venda");
        }catch(\Throwable $e){
            return  $this->redirectToRoute("confirmarPagamentoShow");
        }
      
    }
}