<?php

namespace App\Repository;

use App\Entity\SecondaryEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SecondaryEffect>
 *
 * @method SecondaryEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondaryEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecondaryEffect[]    findAll()
 * @method SecondaryEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecondaryEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondaryEffect::class);
    }

    public function add(SecondaryEffect $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SecondaryEffect $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SecondaryEffect[] Returns an array of SecondaryEffect objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SecondaryEffect
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
