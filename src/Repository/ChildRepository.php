<?php

namespace App\Repository;

use App\Entity\Child;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Child>
 *
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

//    /**
//     * @return Child[] Returns an array of Child objects
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

//    public function findOneBySomeField($value): ?Child
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findLikeName(string $name): array
    {
        //Instanciation d'une variable contenant la requête + obligé d'avoir un alias
        $queryBuilder = $this->createQueryBuilder('c')
        //Exécution d'une requête where
            ->where('c.childLastname LIKE :childLastname')
            ->setParameter('c.childLastname', '%' . $name . '%')
            ->orderBy('c.childLastname', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }


    public function findDisability(): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.isDisabled = true')
            ->orderBy('c.childLastname', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
