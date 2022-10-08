<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Cliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cliente[]    findAll()
 * @method Cliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteRepository extends ServiceEntityRepository
{
	public const PAGINATOR_PER_PAGE = 6;	
	
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cliente::class);
    }
    
    /**
     * @return paginator
     */
    public function getClientPaginator(int $offset): Paginator
	{
		$query = $this->createQueryBuilder('c')                       
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;
        
        return new Paginator($query);
	}
	
	/**
     * @return Client[] Returns an array of Client objects
     */
    
    public function findByFieldValue(int $offset, string $value1, string $value2)
    {    	
    	$value2 = "%{$value2}%";
    	    	
        $qb = $this->createQueryBuilder('c');      
        $query = $qb        	  	
        	->where($qb->expr()->like('c.' . $value1, '?1'))         	        	                    
            ->orderBy('c.id', 'ASC')
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
     
    
	public function findOneById($value): ?Cliente
		{
		return $this->createQueryBuilder('c')
			->andWhere('c.id = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
            

    // /**
    //  * @return Cliente[] Returns an array of Cliente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cliente
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
