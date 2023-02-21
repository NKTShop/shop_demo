<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Cache\Region;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findProduct($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Namep = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }
//search
    public function findBySearch(string $value, Region $region, Category $category)

    {
        return $this->createQueryBuilder('a')
            ->where('a.category = :category')
            ->andWhere('a.region = :region')
            ->andWhere('a.title LIKE :value')
            ->orWhere('a.description LIKE :value')
            ->setParameters([
                'value' => $value,
                'region' => $region,
                'category' => $category
            ])
            ->getQuery()
            ->getResult();
    }

       /**
        * @return Product[] Returns an array of Product objects
        */
       public function findBysearchproduct($search): array
       {
        return $this->createQueryBuilder('p')
        ->andWhere('p.namep like :search')
        ->setParameter('search', '%'.$search.'%')
        ->getQuery()
        ->getArrayResult();
       }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
