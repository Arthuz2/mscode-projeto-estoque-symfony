<?php

namespace App\Controller\Api\Produto;

use App\Repository\CarrinhoRepository;
use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;
use App\Entity\Item;
use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ConsultarController extends AbstractController
{
    #[Route('/api/produto/consultar/{carrinhoId}', name: 'api_produto_consultar', methods:  ['GET'])]
    public function index(
        ProdutoRepository $produtoRepository,
        SerializerInterface $serializer,
        ItemRepository $itemRepository,
        CarrinhoRepository $carrinhoRepository,
        int $carrinhoId
    ): JsonResponse
    {
        try {
            $produtos = $produtoRepository->buscarTodosComEstoque();

            if(!$produtos){
                return $this->json(['error' => 'Nenhum produto encontrado'], 404);
            }
            return new JsonResponse($serializer->serialize($produtos, 'json', ['groups' => 'produto']));
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'erro na consulta de produtos'], 500);
        }
    }
}