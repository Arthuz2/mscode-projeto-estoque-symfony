<?php

namespace App\Controller\Api\Cliente;

use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cliente/ativar', name: 'toggle')]
class AtivarOuDesativarClienteController extends AbstractController
{
    private ClienteRepository $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    
    #[Route('/verificar/ativar/{id}', name: '_verificar_ativar')]
    public function __invoke(int $id): RedirectResponse
    {
        $cliente = $this->clienteRepository->find($id);

        if (!$cliente) {
            throw $this->createNotFoundException('Cliente não encontrado.');
        }

        $message = $cliente->isAtivo()
            ? 'O cliente foi desativado.'
            : 'O cliente foi ativado.';

        $this->addFlash('success', $message);

        $this->clienteRepository->toggleStatus($cliente);

        return $this->redirectToRoute('listar_clientes');
    }
}
