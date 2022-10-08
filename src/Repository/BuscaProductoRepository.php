<?php

namespace App\Repository;

use App\Entity\BuscaProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuscaProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuscaProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuscaProducto[]    findAll()
 * @method BuscaProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuscaProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuscaProducto::class);
    }

    // /**
    //  * @return BuscaProducto[] Returns an array of BuscaProducto objects
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
    public function findOneBySomeField($value): ?BuscaProducto
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
