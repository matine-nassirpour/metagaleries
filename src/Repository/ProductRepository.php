<?php

namespace App\Repository;

use App\Entity\Product;
use App\Search\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Search $search
     * @return Product[]
     */
    public function findWithSearch(Search $search): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c');

        if (!empty($search->categories)) {
            $query = $query->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        /*
        if (!empty($search->string)) {
            $query = $query->andWhere('p.name LIKE :string')
                ->setParameter('string', "%{$search->string}%");
        }
        */

        return $query->getQuery()->getResult();
    }

//    /**
//     * @param int $id
//     * @return Product[]
//     */
//    public function findOneById(int $id): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.id = :id')
//            ->setParameter('id', $id)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
