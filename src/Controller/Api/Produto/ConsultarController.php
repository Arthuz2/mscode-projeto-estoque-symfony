<?php

namespace App\Controller\Api\Produto;

use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ConsultarController extends AbstractController
{
    #[Route('/api/produto/consultar', name: 'api_produto_consultar', methods:  ['GET'])]
    public function index(ProdutoRepository $produtoRepository, SerializerInterface $serializer): JsonResponse
    {
        try {
            $produtos = $produtoRepository->findAll();
            $json =  $serializer->serialize($produtos, 'json', ['groups' => 'produto']);

            return new JsonResponse($json, 200,  [], true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'erro na consulta de produtos'], 500);
        }
    }
}