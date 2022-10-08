<?php

namespace App\Repository;

use App\Entity\BuscaCliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuscaCliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuscaCliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuscaCliente[]    findAll()
 * @method BuscaCliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuscaClienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuscaCliente::class);
    }

    // /**
    //  * @return BuscaCliente[] Returns an array of BuscaCliente objects
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
    public function findOneBySomeField($value): ?BuscaCliente
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
