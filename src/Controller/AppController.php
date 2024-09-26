<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app', methods: 'GET')]
    public function __invoke(Request $request): Response
    {
        return $this->render('app/index.html.twig',[
            'nome' => 'Arthur',
            'headTitle' => '- App',
            'inicioActive' =>  'active',
            'vendasActive' =>  '',
            'produtosActive' =>  '',
        ]);
    }
}
