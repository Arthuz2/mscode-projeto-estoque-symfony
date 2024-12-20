<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\PseudoTypes\True_;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(options: ["default" => true])]
    private bool $ativo = true;

    /**
     * @var Collection<int, Carrinho>
     */
    #[ORM\OneToMany(targetEntity: Carrinho::class, mappedBy: 'cliente')]
    private Collection $carrinhos;

    public function __construct(
        #[ORM\Column(length: 255)]
        private string $nome,
        #[ORM\Column(length: 11)]
        private string $cpf,
    ) {
        $this->cpf = preg_replace("/[^0-9]/", "", $cpf);

        $this->carrinhos = new ArrayCollection();
    }

    public function getId(): int
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
    
    public function isAtivo(): bool
    {
        return $this->ativo;
    }

    public function setStatus(bool $ativo): self
    {
        $this->ativo = $ativo;
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
        ];
    }
}
