<?php

namespace App\Repository;

use App\Entity\ThymioChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThymioChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThymioChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThymioChallenge[]    findAll()
 * @method ThymioChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThymioChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThymioChallenge::class);
    }

    // /**
    //  * @return ThymioChallenge[] Returns an array of ThymioChallenge objects
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
    public function findOneBySomeField($value): ?ThymioChallenge
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
