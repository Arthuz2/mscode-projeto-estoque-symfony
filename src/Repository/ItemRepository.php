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
      
    public function encontrarProdutosPorCarrinhoId($carrinhoId): ?Carrinho
    {
        
        dd("chego aqui");
        return
        $this->createQueryBuilder('i')
            ->select('p')
            ->join('i.produto', 'p')
            ->where('i.carrinho = :carrinho_id_id')
            ->setParameter('carrinho_id_id', $carrinhoId)
            ->getQuery()
            ->getResult();
    }
}
