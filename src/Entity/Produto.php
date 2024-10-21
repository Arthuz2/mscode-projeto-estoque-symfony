<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nome = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_cadastro = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantidade_inicial = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantidade_disponivel = null;

    #[ORM\Column(nullable: true)]
    private ?int $valor = null;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    private ?Categoria $categoria_id = null;

    #[ORM\Column]
    private ?int $valor_unitario = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $atualizado_em = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeInterface
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro(?\DateTimeInterface $data_cadastro): static
    {
        $this->data_cadastro = $data_cadastro;

        return $this;
    }

    public function getQuantidadeInicial(): ?int
    {
        return $this->quantidade_inicial;
    }

    public function setQuantidadeInicial(?int $quantidade_inicial): static
    {
        $this->quantidade_inicial = $quantidade_inicial;

        return $this;
    }

    public function getQuantidadeDisponivel(): ?int
    {
        return $this->quantidade_disponivel;
    }

    public function setQuantidadeDisponivel(?int $quantidade_disponivel): static
    {
        $this->quantidade_disponivel = $quantidade_disponivel;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(?int $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCategoriaId(): ?Categoria
    {
        return $this->categoria_id;
    }

    public function setCategoriaId(?Categoria $categoria_id): static
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }

    public function getValorUnitario(): ?int
    {
        return $this->valor_unitario;
    }

    public function setValorUnitario(int $valor_unitario): static
    {
        $this->valor_unitario = $valor_unitario;

        return $this;
    }

    public function getAtualizadoEm(): ?\DateTimeInterface
    {
        return $this->atualizado_em;
    }

    public function setAtualizadoEm(\DateTimeInterface $atualizado_em): static
    {
        $this->atualizado_em = $atualizado_em;

        return $this;
    }
}
