<?php

namespace App\Repository;

use App\Entity\Categoria;
use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categoria>
 */
class CategoriaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function salvar(Categoria $categoria): void
    {
        $this->getEntityManager()->persist($categoria);
        $this->getEntityManager()->flush();
    }

    public function excluir(Categoria $categoria)
    {
        $this->getEntityManager()->remove($categoria);
        $this->getEntityManager()->flush();
    }
}
