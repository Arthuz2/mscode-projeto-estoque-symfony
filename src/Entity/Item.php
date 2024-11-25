<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\ErrorHandler\ThrowingTest;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?int $valor;

    #[ORM\ManyToOne(targetEntity: Produto::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produto $produto;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Carrinho $carrinho;

    public function __construct(
        Carrinho    $carrinho,
        Produto $produto
    )
    {
        $this->produto = $produto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(?Produto $produto): static
    {
        $this->produto = $produto;

        return $this;
    }

    public function getCarrinho(): ?Carrinho
    {
        return $this->carrinho;
    }

    public function setCarrinho(?Carrinho $carrinho): static
    {
        $this->carrinho = $carrinho;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'valor' => $this->valor,
            'produto' => $this->produto
           
        ];
    }
}
