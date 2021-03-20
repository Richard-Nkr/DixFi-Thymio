<?php

namespace App\Repository;

use App\Entity\PrivateChallenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivateChallenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivateChallenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivateChallenge[]    findAll()
 * @method PrivateChallenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivateChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivateChallenge::class);
    }

}
