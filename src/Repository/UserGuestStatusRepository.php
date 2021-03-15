<?php

namespace App\Repository;

use App\Entity\ThymioChallenge;
use App\Entity\UserGuestStatus;
use App\Service\HandleStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method UserGuestStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGuestStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGuestStatus[]    findAll()
 * @method UserGuestStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGuestStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGuestStatus::class);
    }


    public function findOneById($id): ?UserGuestStatus
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return UserGuestStatus[] Returns an array of UserGuestStatus objects
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
    public function findOneBySomeField($value): ?UserGuestStatus
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
