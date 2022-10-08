<?php

namespace App\Repository;

use App\Entity\PedidoCallCenter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method PedidoCallCenter|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoCallCenter|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoCallCenter[]    findAll()
 * @method PedidoCallCenter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoCallCenterRepository extends ServiceEntityRepository
{
	public const PAGINATOR_PER_PAGE = 6;	
	
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PedidoCallCenter::class);
    }
    
    /**
     * @return paginator
     */
    public function getPedidoPaginator(int $offset): Paginator
	{
		$query = $this->createQueryBuilder('p')                       
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;
        
        return new Paginator($query);                      												                                
	}
	
	/**
     * @return Pedido[] Returns an array of Pedido objects
     */
    
    public function findByFieldValue(int $offset, string $value1, string $value2): Paginator
    {    	
    	$value2 = "%{$value2}%";
    	    	
        $qb = $this->createQueryBuilder('p');      
        $query = $qb        	  	
        	->where($qb->expr()->like('p.' . $value1, '?1'))         	        	                    
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->setParameter(1, $value2)
            ->getQuery()            
        ;                                     
        
        return new Paginator($query);
    }
    
    /**
     * @return last value for paginator
     */
     public function getLast($paginator): ?int {
     	// Cálcula el valor a asignar a la variable $last para ir al último registro del listado    	
    	if(count($paginator) % self::PAGINATOR_PER_PAGE == 0) {
    		$last = (floor(count($paginator) / self::PAGINATOR_PER_PAGE) * self::PAGINATOR_PER_PAGE) - (self::PAGINATOR_PER_PAGE);    		
    	}
    	else {
    		$last = (floor(count($paginator) / self::PAGINATOR_PER_PAGE) * self::PAGINATOR_PER_PAGE);	
    	}
    	
    	return $last;
     }   

    // /**
    //  * @return PedidoCallCenter[] Returns an array of PedidoCallCenter objects
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

    /*
    public function findOneBySomeField($value): ?PedidoCallCenter
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
