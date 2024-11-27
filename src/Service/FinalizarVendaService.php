<?php 
namespace App\Service;

use App\Controller\Exceptions\ProdutoJaAdicionadoAoCarrinhoException;
use App\Entity\Carrinho;
use App\Entity\Item;
use App\Repository\CarrinhoRepository;
use App\Entity\StatusEnum;
use App\Repository\ClienteRepository;
use App\Repository\ItemRepository;
use App\Repository\ProdutoRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalizarVendaService 
{
    public function __construct(
        private CarrinhoRepository $carrinhoRepository,
        private ClienteRepository $clienteRepository,
        private ProdutoRepository $produtoRepository,
        private ItemRepository $itemRepository,
    ) {
    }
    
    public function execute(int $clienteId, array $produtos): Carrinho
    {
        dd($clienteId,$produtos);
        $cliente = $this->clienteRepository->find($clienteId);
        $carrinho = $this->carrinhoRepository->buscarUltimoCarrinhoPendente(["cliente" => $cliente]);

        if(null === $carrinho){
            throw new \Exception("O cliente não possui nenhum carrinho pendente a ser finalizado!!");
        }
       
        foreach($produtos as $produto){
            dd($produto);
            $produtoId = $produto['id']; 
            $quantidade = $produto['quantidade']; 
            
            $produtoEncontrado = $this->produtoRepository->find($produtoId);
            $quantidadeDisponivel = $produtoEncontrado->getQuantidadeDisponivel();

            if (!$produtoEncontrado) {
                throw new \Exception("Produto não encontrado");
            }
            $valorTotalProduto = $quantidade * $produtoEncontrado->getValor();

            if ($produtoEncontrado->getQuantidadeDisponivel() < 1) {
                throw new BadRequestHttpException('O produto está fora de estoque ou não possui quantidade suficiente.');
            }

            if ($this->itemRepository->findOneBy(['carrinho' => $carrinho, 'produto' > $produtoEncontrado])) {
                throw new ProdutoJaAdicionadoAoCarrinhoException();
            }
    
            $item = new Item(
                $carrinho, 
                $produtoEncontrado,
                $valorTotalProduto,
                $quantidade
            );
            $this->itemRepository->salvar($item);
            $carrinho->addItem($item);

            $produtoEncontrado->setQuantidadeDisponivel($quantidadeDisponivel - $quantidade);
            $this->produtoRepository->salvar($produtoEncontrado);
        }
        
        if ($carrinho->getItems()->isEmpty()) {
            throw new BadRequestHttpException('O carrinho não contém produtos.');
        }

        if ($carrinho->getStatus() !== StatusEnum::aberto) {
            throw new BadRequestHttpException('Não é possível finalizar um carrinho que não está em aberto.');
        }

        $carrinho->setStatus(StatusEnum::aguardandoPagamento);
        return $this->carrinhoRepository->salvar($carrinho);
    } 
}

