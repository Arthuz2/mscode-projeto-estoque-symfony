<?php

namespace App\Controller\Api\Produto;

use App\Repository\CarrinhoRepository;
use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;
use Container3Q2SPOz\getCarrinhoRepositoryService;
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
            $produtos = $produtoRepository->findAll();
            $carrinho = $carrinhoRepository->find($carrinhoId);
            $itensNocarrinho = $itemRepository->findBy(["carrinho" => $carrinho]);

            $produtosNoCarrinho = array_map(function($item){
                return $item->getProduto()->getId();
            },$itensNocarrinho);
           
            $produtoFiltro = array_filter($produtos,function($produto) use ($produtosNoCarrinho) {
                return !in_array($produto->getId(),$produtosNoCarrinho);
            });

            if(!$produtos){
                return $this->json(['error' => 'Nenhum produto encontrado'], 404);
            }

            return new JsonResponse($serializer->serialize($produtoFiltro, 'json', ['groups' => 'produto']));
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'erro na consulta de produtos'], 500);
        }
    }
}