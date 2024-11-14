<?php

namespace App\Entity;

use App\Repository\CarrinhoRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrinhoRepository::class)]
class Carrinho implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne(inversedBy: 'carrinhos')]
    private ?Cliente $cliente;

    #[ORM\ManyToOne(inversedBy: 'carrinhos')]
    private ?Usuario $usuario;

    #[ORM\Column(type: 'string', enumType: StatusEnum::class)]
    private StatusEnum $status = StatusEnum::aberto;

    
    #[ORM\Column(nullable: true)]
    private ?int $valor_total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $criado_em;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $atualizado_em = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finalizado_em = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'carrinho')]
    private Collection $items;

    public function __construct(
        Cliente $cliente
    )
    {
        $this->criado_em = new DateTimeImmutable();
        $this->items = new ArrayCollection();
        $this->cliente = $cliente;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getValorTotal(): ?int
    {
        return $this->valor_total;
    }

    public function setValorTotal(int $valor_total): static
    {
        $this->valor_total = $valor_total;

        return $this;
    }

    public function getCriadoEm(): ?\DateTimeInterface
    {
        return $this->criado_em;
    }

    public function setCriadoEm(\DateTimeInterface $criado_em): static
    {
        $this->criado_em = $criado_em;

        return $this;
    }

    public function getAtualizadoEm(): ?\DateTimeInterface
    {
        return $this->atualizado_em;
    }

    public function setAtualizadoEm(?\DateTimeInterface $atualizado_em): static
    {
        $this->atualizado_em = $atualizado_em;

        return $this;
    }

    public function getFinalizadoEm(): ?\DateTimeInterface
    {
        return $this->finalizado_em;
    }

    public function setFinalizadoEm(?\DateTimeInterface $finalizado_em): static
    {
        $this->finalizado_em = $finalizado_em;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCarrinho($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCarrinho() === $this) {
                $item->setCarrinho(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'cliente'  => $this->cliente,
            'usuario' => $this->usuario,
            'status' => $this->status,
            'valor_total'  => $this->valor_total,
            'criado_em' => $this->criado_em,
            'finalizado_em' => $this->finalizado_em,   
            'items' => $this->items->toArray(),

        ];
    }

}
