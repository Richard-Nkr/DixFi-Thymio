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



    public function findOneById($id): ?UserGuest
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
