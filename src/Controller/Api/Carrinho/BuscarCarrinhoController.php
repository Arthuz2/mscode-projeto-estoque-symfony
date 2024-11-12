<?php

namespace App\Controller\Api\Carrinho;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\StatusEnum;
use App\Entity\Carrinho;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuscarCarrinhoController extends AbstractController
{
   
    
    #[Route("/api/buscar-ou-criar-carrinho", name:"buscar_carrinho", methods:["GET"])]
    public function __invoke():JsonResponse
    {
        try{
            $carrinho = new Carrinho();

            if($carrinho->getStatus() !== StatusEnum::aberto){
                return $this->json(['error' => 'Nenhum carrinho encontrado']);
            }

            if($carrinho->getStatus() === StatusEnum::aberto){
                return new JsonResponse(["carrinho" => $carrinho]);
            }
        } catch (\Throwable $e){
            return new JsonResponse(
                ['error' => $e->getMessage()],
               
            );
        }
      
    }
}