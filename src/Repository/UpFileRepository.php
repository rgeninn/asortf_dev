<?php

namespace App\Repository;

use App\Entity\UpFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UpFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method UpFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method UpFile[]    findAll()
 * @method UpFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UpFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UpFile::class);
    }

    // /**
    //  * @return UpFile[] Returns an array of UpFile objects
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
    public function findOneBySomeField($value): ?UpFile
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
