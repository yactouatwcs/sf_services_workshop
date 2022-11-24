<?php

namespace App\Repository;

use App\Entity\ConversionRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversionRate>
 *
 * @method ConversionRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversionRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversionRate[]    findAll()
 * @method ConversionRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversionRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversionRate::class);
    }

    public function add(ConversionRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConversionRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConversionRate[] Returns an array of ConversionRate objects
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

   public function findOneByConversion(string $currencyA, string $currencyB): ?ConversionRate
   {
       return $this->createQueryBuilder('c')
           ->andWhere('c.currencyA = :currencyA')
           ->andWhere('c.currencyB = :currencyB')
           ->setParameter('currencyA', $currencyA)
           ->setParameter('currencyB', $currencyB)
           ->orderBy('c.updated_at', 'DESC')
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
