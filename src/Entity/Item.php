<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\Column]
    private ?int $valor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produto $produto_id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carrinho $carrinho_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getProdutoId(): ?Produto
    {
        return $this->produto_id;
    }

    public function setProdutoId(?Produto $produto_id): static
    {
        $this->produto_id = $produto_id;

        return $this;
    }

    public function getCarrinhoId(): ?Carrinho
    {
        return $this->carrinho_id;
    }

    public function setCarrinhoId(?Carrinho $carrinho_id): static
    {
        $this->carrinho_id = $carrinho_id;

        return $this;
    }
}
