<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        // if (empty($_SESSION['_sf2_meta'])){
        //     return $this->redirectToRoute('app');
        // }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = null;

        return $this->render('login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'usuario' => $user,
        ]);
    }

    #[Route(path: '/usuario/verificar/', name: '_verificar')]
    public function ativoOuInativo(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager)
    {

        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $lastUsername]);

        if ($user->taAtivo() == false) {
            return $this->redirectToRoute('login');
        } else {
            return $this->redirectToRoute('nova_venda');
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->redirect('login');
    }
}
