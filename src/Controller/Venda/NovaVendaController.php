<?php

namespace App\Controller\Venda;

use App\Controller\DefaultController;
use App\Entity\Usuario;
use App\Repository\CarrinhoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NovaVendaController extends DefaultController
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
    ) {
        
    }

    #[Route('/{clienteId?}', name: 'nova_venda')]
    public function novaVenda(?string $clienteId = null): Response
    {

        if(!$this->isUsuarioAtivo()){
            return $this->logoutUsuario();
        }

        $carrinhos = $this->carrinhoRepository->findAll();
        return $this->render('venda/novaVenda.html.twig', [
            "carrinhos" => $carrinhos,
            "clienteId" => $clienteId,
        ]);
    }
}
