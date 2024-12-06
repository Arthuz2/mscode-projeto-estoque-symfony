<?php

namespace App\Controller\Usuario;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CadastrarUsuarioController extends AbstractController
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    #[Route('/usuario/cadastrar/show', name: 'cadastrar_usuario_show')]
    public function index(): Response
    {
        return $this->render('usuario/cadastrar_usuario.html.twig');
    }

    #[Route('/usuario/cadastrar', name: 'cadastrar_usuario')]
    public function __invoke(Request $request, AuthenticationUtils $authenticationUtils, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $usuario = new Usuario();
        $data = $request->request->all();

        if (!isset($data['_password'], $data['_username'])) {
            $this->addFlash('error', 'Os dados do formulário estão incompletos.');
            return $this->redirectToRoute('cadastrar_usuario'); // Redireciona para a página do formulário
        }
        
        $usuarioExistente = $this->usuarioRepository->findOneBy(['email' => $data['_username']]);
    if ($usuarioExistente) {
        $this->addFlash('error', 'O e-mail informado já está cadastrado.');
        return $this->redirectToRoute('cadastrar_usuario_show'); 
    }

        $senha_hash = $userPasswordHasherInterface->hashPassword($usuario, $data['_password']);
        $usuario ->setEmail($data['_username']) ->setPassword($senha_hash) ->setRoles(['ROLE_USER']);

        $this->usuarioRepository->salvar($usuario);

        $this->addFlash('success', 'Usuário cadastrado com sucesso.');

        return $this->redirectToRoute('listar_usuarios');
    }
}
