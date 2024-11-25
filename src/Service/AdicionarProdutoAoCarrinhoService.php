<?php

namespace App\Service;

use App\Controller\Exceptions\ProdutoJaAdicionadoAoCarrinhoException;
use App\Entity\Carrinho;
use App\Entity\Item;
use App\Repository\CarrinhoRepository;
use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;

class AdicionarProdutoAoCarrinhoService
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CarrinhoRepository $carrinhoRepository,
        private ItemRepository $itemRepository,
    )
    {
    }

    public function execute(int $produtoId, int $carrinhoId): Carrinho
    {
        $produto = $this->produtoRepository->find($produtoId);
        if (!$produto) {
            throw new \Exception("Produto não encontrado");
        }
    
        $carrinho = $this->carrinhoRepository->find($carrinhoId);
        if (!$carrinho) {
            throw new \Exception("Carrinho não encontrado");
        }
        
        if ($this->itemRepository->findOneBy(['carrinho' => $carrinho, 'produto' => $produto])) {
            throw new ProdutoJaAdicionadoAoCarrinhoException();
        }
         
        $item = new Item($carrinho, $produto);
        $item->setValor($produto->getValor());
        $this->itemRepository->salvar($item);
 
        $carrinho->addItem($item);
        return $this->carrinhoRepository->salvar($carrinho);
    }
}