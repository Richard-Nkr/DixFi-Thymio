<?php

namespace App\Repository;

use App\Entity\UserGuest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserGuest|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGuest|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGuest[]    findAll()
 * @method UserGuest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGuest::class);
    }

    // /**
    //  * @return UserGuest[] Returns an array of UserGuest objects
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
    public function findOneBySomeField($value): ?UserGuest
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
