<?php

namespace App\Repository;

use App\Entity\DateDelivrance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DateDelivrance>
 *
 * @method DateDelivrance|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateDelivrance|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateDelivrance[]    findAll()
 * @method DateDelivrance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateDelivranceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DateDelivrance::class);
    }

    public function add(DateDelivrance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DateDelivrance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DateDelivrance[] Returns an array of DateDelivrance objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DateDelivrance
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
