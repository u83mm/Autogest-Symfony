<?php

namespace App\Repository;

use App\Entity\TipoEstado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoEstado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoEstado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoEstado[]    findAll()
 * @method TipoEstado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoEstadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoEstado::class);
    }

    public function findOneById($value): ?TipoEstado
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return TipoEstado[] Returns an array of TipoEstado objects
     */

    public function findByFieldValue(string $value1, string $value2)
    {    	
    	$value2 = "%{$value2}%";

        $qb = $this->createQueryBuilder('e');      
        $query = $qb        	  	
        	->where($qb->expr()->like('e.' . $value1, '?1'))         	        	                    
            ->orderBy('e.id', 'ASC')                        
            ->setParameter(1, $value2)
            ->getQuery()            
        ;                                     

        return $query->getResult();
    }

    // /**
    //  * @return TipoEstado[] Returns an array of TipoEstado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoEstado
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
