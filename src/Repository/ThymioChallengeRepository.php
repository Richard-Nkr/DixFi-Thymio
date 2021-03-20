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

}
