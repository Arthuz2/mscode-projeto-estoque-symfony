<?php

namespace App\Entity;

use App\Repository\CarrinhoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarrinhoRepository::class)]
class Carrinho
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Cliente>
     */
    #[ORM\ManyToMany(targetEntity: Cliente::class)]
    private Collection $cliente_id;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'carrinhos')]
    private Collection $usuario_id;

    #[ORM\Column(length: 25)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $valor_total = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $criado_em = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $atualizado_em = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $finalizado_em = null;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\OneToMany(targetEntity: Item::class, mappedBy: 'carrinho_id')]
    private Collection $items;

    public function __construct()
    {
        $this->cliente_id = new ArrayCollection();
        $this->usuario_id = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getClienteId(): Collection
    {
        return $this->cliente_id;
    }

    public function addClienteId(Cliente $clienteId): static
    {
        if (!$this->cliente_id->contains($clienteId)) {
            $this->cliente_id->add($clienteId);
        }

        return $this;
    }

    public function removeClienteId(Cliente $clienteId): static
    {
        $this->cliente_id->removeElement($clienteId);

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarioId(): Collection
    {
        return $this->usuario_id;
    }

    public function addUsuarioId(Usuario $usuarioId): static
    {
        if (!$this->usuario_id->contains($usuarioId)) {
            $this->usuario_id->add($usuarioId);
        }

        return $this;
    }

    public function removeUsuarioId(Usuario $usuarioId): static
    {
        $this->usuario_id->removeElement($usuarioId);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function setAtualizadoEm(\DateTimeInterface $atualizado_em): static
    {
        $this->atualizado_em = $atualizado_em;

        return $this;
    }

    public function getFinalizadoEm(): ?\DateTimeInterface
    {
        return $this->finalizado_em;
    }

    public function setFinalizadoEm(\DateTimeInterface $finalizado_em): static
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
            $item->setCarrinhoId($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCarrinhoId() === $this) {
                $item->setCarrinhoId(null);
            }
        }

        return $this;
    }
}
