<?php

namespace App\Repository;

use App\Entity\Child;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Child|null find($id, $lockMode = null, $lockVersion = null)
 * @method Child|null findOneBy(array $criteria, array $orderBy = null)
 * @method Child[]    findAll()
 * @method Child[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Child::class);
    }


    public function findNumberChildrenByStudentGroup($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.studentGroup = :val')
            ->setParameter('val', $value)
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult();

    }
    
}
