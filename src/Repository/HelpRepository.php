<?php

namespace App\Repository;

use App\Entity\Help;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Help|null find($id, $lockMode = null, $lockVersion = null)
 * @method Help|null findOneBy(array $criteria, array $orderBy = null)
 * @method Help[]    findAll()
 * @method Help[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HelpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Help::class);
    }


    public function findByIdChallenge($id):array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.challenge = :val')
            ->setParameter('val', $id)
            ->orderBy('h.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
