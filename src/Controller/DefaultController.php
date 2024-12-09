<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController{

    protected function isUsuarioAtivo(): bool {

        $user = $this->getUser();
        assert($user instanceof Usuario);

        return $user->isAtivo();
    }

    protected function logoutUsuario(){
        return $this->redirectToRoute('app_logout');
    }
}