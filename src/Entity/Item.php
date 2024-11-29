<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;


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
    private Produto $produto;

    #[ORM\ManyToOne(targetEntity: Carrinho::class , inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Carrinho $carrinho;

    #[ORM\Column]
    private int $quantidade;

    public function __construct(
        Carrinho $carrinho,
        Produto $produto,
        int $valor,
        int $quantidade
    ) {
        $this->produto = $produto;
        $this->valor = $valor;
        $this->carrinho = $carrinho;
        $this->quantidade = $quantidade;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function getCarrinho(): ?Carrinho
    {
        return $this->carrinho;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'valor' => $this->valor,
            'produto' => $this->produto,
            "quantidade" => $this->quantidade,
        ];
    }
}
