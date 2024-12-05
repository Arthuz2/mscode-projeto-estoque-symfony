<?php

namespace App\Controller\Usuario;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario/cadastrar', name: 'cadastrar_usuario')]
class CadastrarUsuarioController extends AbstractController
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usuario = new Usuario();

        $form = $this->createForm(Usuario::class, $usuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($usuario);
            $entityManager->flush();

            $this->addFlash('success', 'Usuário cadastrado com sucesso.');

            return $this->redirectToRoute('listar_usuario');
        }

        return $this->render('usuario/cadastrar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
