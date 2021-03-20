<?php

namespace App\Repository;


use App\Entity\UserGuestStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

}
