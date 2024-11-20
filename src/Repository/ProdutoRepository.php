<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produto>
 */
class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function salvar(Produto $produto): void
    {
        $this->getEntityManager()->persist($produto);
        $this->getEntityManager()->flush();
    }

    public function editar(Produto $produto): void
    {
        $this->getEntityManager()->flush();
    }
    
    public function excluir(Produto $produto): void
    {
        $this->getEntityManager()->remove($produto);
        $this->getEntityManager()->flush();
    }
}
