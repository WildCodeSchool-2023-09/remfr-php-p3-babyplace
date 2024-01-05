<?php

namespace App\Repository;

use App\Entity\Creche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Creche>
 *
 * @method Creche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creche[]    findAll()
 * @method Creche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CrecheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creche::class);
    }

//    /**
//     * @return Creche[] Returns an array of Creche objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Creche
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
