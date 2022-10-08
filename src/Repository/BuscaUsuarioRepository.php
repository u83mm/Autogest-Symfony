<?php

namespace App\Repository;

use App\Entity\BuscaUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuscaUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuscaUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuscaUsuario[]    findAll()
 * @method BuscaUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuscaUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuscaUsuario::class);
    }

    // /**
    //  * @return BuscaUsuario[] Returns an array of BuscaUsuario objects
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
    public function findOneBySomeField($value): ?BuscaUsuario
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
