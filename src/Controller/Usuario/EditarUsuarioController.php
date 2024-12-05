<?php

namespace App\Controller\Usuario;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario/editar/{id}', name: 'editar_usuario')]
class EditarUsuarioController extends AbstractController
{
    public function __invoke(Usuario $usuario, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Usuario::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Usuário atualizado com sucesso.');

            return $this->redirectToRoute('listar_usuario');
        }

        return $this->render('usuario/editar.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
