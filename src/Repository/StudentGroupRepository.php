<?php

namespace App\Repository;

use App\Entity\StudentGroup;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentGroup[]    findAll()
 * @method StudentGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentGroup::class);
    }

    /**
     * @param Teacher $teacher
     * @return Teacher[] Returns an array of Teacher objects
     */
    public function findByTeacher(Teacher $teacher): ?array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.teacher = :val')
            ->setParameter('val', $teacher)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneById($id): ?StudentGroup
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


}
