<?php

namespace App\Controller\Cliente;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use App\Service\ValidarCpfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CadastrarClienteController extends AbstractController
{
    private ClienteRepository $clienteRepository;
    private ValidarCpfService $validarCpfService;

    public function __construct(ClienteRepository $clienteRepository, ValidarCpfService $validarCpfService)
    {
        $this->clienteRepository = $clienteRepository;
        $this->validarCpfService = $validarCpfService;
    }

    #[Route('/cliente/cadastrar/show', name: 'cadastrar_cliente_show')]
    public function index(): Response
    {
        return $this->render('cliente/cadastrar_cliente.html.twig');
    }

    #[Route('/cliente/cadastrar', name: 'cadastrar_cliente')]
    public function __invoke(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $data = $request->request->all();

        if (!isset($data['_nome'], $data['_cpf'])) {
            $this->addFlash('error', 'Os dados do formulário estão incompletos.');
            return $this->redirectToRoute('cadastrar_cliente_show'); 
        }

        $nome = $data['_nome'];
        $cpf = $data['_cpf'];

        if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nome)) {
            $this->addFlash('error', 'O nome deve conter apenas letras e espaços.');
            return $this->redirectToRoute('cadastrar_cliente_show');
        }

        // Validar o CPF utilizando o serviço ValidarCpfService
        if (!$this->validarCpfService->execute($cpf)) {
            $this->addFlash('error', 'O CPF informado é inválido.');
            return $this->redirectToRoute('cadastrar_cliente_show');
        }

        $clienteExistente = $this->clienteRepository->findOneBy(['cpf' => $cpf]);
        if ($clienteExistente) {
            $this->addFlash('error', 'O CPF informado já está cadastrado.');
            return $this->redirectToRoute('cadastrar_cliente_show');
        }

        $cliente = new Cliente($nome, $cpf);
        $cliente->setNome($nome)->setCpf($cpf);

        $this->clienteRepository->salvar($cliente);

        $this->addFlash('success', 'Cliente cadastrado com sucesso.');

        return $this->redirectToRoute('listar_clientes');
    }
}
