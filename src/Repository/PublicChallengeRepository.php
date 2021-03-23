<?php

namespace App\Repository;

use App\Entity\PublicChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PublicChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicChallenge[]    findAll()
 * @method PublicChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublicChallenge::class);
    }

    public function findOneById($id): ?PublicChallenge
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
