<?php

namespace App\Controller\Error;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotFoundController extends AbstractController
{
    #[Route('/error', name: '404')]
    public function index(): Response
    {
        return $this->render('error/404.html.twig');
    }
}
