<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Cliente>
 */
class ClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        
        parent::__construct($registry, Cliente::class);
        
    }

    public function salvar(Cliente $cliente): Cliente
    {
        $this->getEntityManager()->persist($cliente);
        $this->getEntityManager()->flush();

        return $cliente;
    }

    public function toggleStatus(Cliente $cliente): void
    {
        $cliente->setStatus(!$cliente->isAtivo());

        $this->getEntityManager()->persist($cliente);
        $this->getEntityManager()->flush();
    }
}
