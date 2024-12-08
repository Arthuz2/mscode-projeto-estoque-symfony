<?php

namespace App\Repository;

use App\Entity\Carrinho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\StatusEnum;
/**
 * @extends ServiceEntityRepository<Carrinho>
 */
class CarrinhoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carrinho::class);
    }

    public function salvar(Carrinho $carrinho):Carrinho
    {
        $this->getEntityManager()->persist($carrinho);
        $this->getEntityManager()->flush();
        return $carrinho;
    }
    public function buscarUltimoCarrinhoAbertoPendente($cliente): Carrinho
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.cliente = :cliente')
            ->andWhere('c.status = :status')
            ->andWhere('c.finalizado_em IS NULL')  // Carrinho não finalizado
            ->setParameter('cliente', $cliente)
            ->setParameter('status', StatusEnum::aberto)  // Status aberto
            ->orderBy('c.id', 'DESC')  // Busca o mais recente
            ->setMaxResults(1)  // Apenas 1 resultado
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function buscarUltimoCarrinhoPendente($cliente): ?Carrinho
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.cliente = :cliente')
            ->andWhere('c.finalizado_em IS NULL')  // Carrinho não finalizado
            ->setParameter('cliente', $cliente)
            ->orderBy('c.id', 'DESC')  // Busca o mais recente
            ->setMaxResults(1)  // Apenas 1 resultado
            ->getQuery()
            ->getOneOrNullResult();
    }

}
