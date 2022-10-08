<?php

namespace App\Repository;

use App\Entity\BuscaPedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuscaPedido|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuscaPedido|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuscaPedido[]    findAll()
 * @method BuscaPedido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuscaPedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuscaPedido::class);
    }

    // /**
    //  * @return BuscaPedido[] Returns an array of BuscaPedido objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuscaPedido
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
