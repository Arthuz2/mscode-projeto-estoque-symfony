<?php

namespace App\Controller\Usuario;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario/excluir/{id}', name: 'excluir_usuario')]
class ExcluirUsuarioController extends AbstractController
{
    public function __invoke(Usuario $usuario, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($usuario);
        $entityManager->flush();

        $this->addFlash('success', 'Usuário excluído com sucesso.');

        return $this->redirectToRoute('listar_usuario');
    }
}
