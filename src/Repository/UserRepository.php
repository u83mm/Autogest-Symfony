<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
	public const PAGINATOR_PER_PAGE = 6;		

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return paginator
     */
    public function getUserPaginator(int $offset): Paginator
	{
		$query = $this->createQueryBuilder('u')                       
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
	}

	/**
     * @return User[] Returns an array of User objects
     */

    public function findByFieldValue(int $offset, string $value1, string $value2)
    {    	
    	$value2 = "%{$value2}%";

        $qb = $this->createQueryBuilder('u');      
        $query = $qb        	  	
        	->where($qb->expr()->like('u.' . $value1, '?1'))         	        	                    
            ->orderBy('u.id', 'ASC')
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
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
