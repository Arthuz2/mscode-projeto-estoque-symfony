<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nome = null;

    #[ORM\Column(length: 11)]
    private ?string $cpf = null;

    /**
     * @var Collection<int, Carrinho>
     */
    #[ORM\OneToMany(targetEntity: Carrinho::class, mappedBy: 'cliente')]
    private Collection $carrinhos;

    public function __construct()
    {
        $this->carrinhos = new ArrayCollection();
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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<int, Carrinho>
     */
    public function getCarrinhos(): Collection
    {
        return $this->carrinhos;
    }

    public function addCarrinho(Carrinho $carrinho): static
    {
        if (!$this->carrinhos->contains($carrinho)) {
            $this->carrinhos->add($carrinho);
            $carrinho->setCliente($this);
        }

        return $this;
    }

    public function removeCarrinho(Carrinho $carrinho): static
    {
        if ($this->carrinhos->removeElement($carrinho)) {
            // set the owning side to null (unless already changed)
            if ($carrinho->getCliente() === $this) {
                $carrinho->setCliente(null);
            }
        }

        return $this;
    }
}
