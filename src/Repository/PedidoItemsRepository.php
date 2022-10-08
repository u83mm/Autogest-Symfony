<?php

namespace App\Repository;

use App\Entity\PedidoItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PedidoItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoItems[]    findAll()
 * @method PedidoItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidoItems::class);
    }

    // /**
    //  * @return PedidoItems[] Returns an array of PedidoItems objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
    public function findByPedidoCallCenter($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.PedidoCallCenter = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')           
            ->getQuery()
            ->getResult()
        ;
    }
        
    public function findOneByPedidoId($value): ?PedidoItems
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.pedidoId = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?PedidoItems
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
