<?php

namespace App\Repository;

use App\Entity\Carrinho;
use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function salvar(Item $item):Item
    {
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
        return $item;
    }
}
