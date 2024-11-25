<?php

namespace App\Controller\Api\Produto;

use App\Controller\Exceptions\ProdutoJaAdicionadoAoCarrinhoException;
use App\Service\AdicionarProdutoAoCarrinhoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


class AdicionarController extends AbstractController
{
    #[Route('/api/adicionarProduto/{produtoId}/carrinho/{carrinhoId}', name:"adicionar")]
    public function __invoke(
        int $produtoId,
        int $carrinhoId,
        AdicionarProdutoAoCarrinhoService $adicionarProdutoAoCarrinho,
    ): JsonResponse
    {
        try {
            $adicionarProdutoAoCarrinho->execute($produtoId, $carrinhoId);
            return new JsonResponse(['success' => 'Produto adicionado ao carrinho']);
        } catch (ProdutoJaAdicionadoAoCarrinhoException $e) {
            return new JsonResponse(["error" => $e->getMessage()],409);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}