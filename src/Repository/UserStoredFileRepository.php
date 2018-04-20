<?php

namespace App\Repository;

use App\Entity\UserStoredFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserStoredFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserStoredFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserStoredFile[]    findAll()
 * @method UserStoredFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserStoredFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserStoredFile::class);
    }

//    /**
//     * @return UploadedFile[] Returns an array of UploadedFile objects
//     */
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
    public function findOneBySomeField($value): ?UploadedFile
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
