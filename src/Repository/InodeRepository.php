<?php

namespace App\Repository;

use App\Entity\Inode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inode[]    findAll()
 * @method Inode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inode::class);
    }

     /**
      * @return Inode[] Returns an array of Inode objects
      */
    public function getCloudElements($parent, $access, $order = null)
    {
        // Create Main Query
        $query = $this->createQueryBuilder('inode');
        $query->join('inode.parent', 'parent');
        $query->join('inode.access', 'access');

        if ($parent !== null)
            $query->andWhere("parent.id = ".$parent->getId());

        if ($access !== null)
            $query->andWhere("access.id = ".$access);

        $query->addOrderBy('inode.type', 'ASC');

        if ($order !== null)
            $query->addOrderBy("inode." . $order, "ASC");

        return $query->getQuery()->getResult();
    }

    public function getChildren($inode, $access, $order = null)
    {
        // Create Main Query
        $query = $this->createQueryBuilder('inode');

        $query->join('inode.parent', 'parent');

        $query->andWhere("parent.id = ".$inode->getId());

        $query->join('inode.access', 'access');

        $query->andWhere("access.id = ".$access);

        $query->addOrderBy('inode.type', 'ASC');

        if ($order !== null)
            $query->addOrderBy("inode." . $order, "ASC");

        return $query->getQuery()->getResult();
    }

    public function getFolderChildren($inode, $access, $order = null)
    {
        // Create Main Query
        $query = $this->createQueryBuilder('inode');

        $query->join('inode.parent', 'parent');

        $query->andWhere("parent.id = ".$inode->getId());

        $query->join('inode.access', 'access');

        $query->andWhere("access.id = ".$access);

        $query->andWhere("inode.type = 1");

        if ($order !== null)
            $query->addOrderBy("inode." . $order, "ASC");

        return $query->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Inode
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
