<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function findWithSearch($parameters){

        $tipo = $parameters['tipo'];
        $taglia = $parameters['taglia'];

        $qb = $this
                ->createQueryBuilder('p')
                ->select('c', 'p', 's')
                ->join('p.category', 'c')
                ->join('p.size', 's');

        if($tipo != 'Tipo') {
            $qb = $qb
                    ->andWhere('c.name = (:tipo)')
                    ->setParameter('tipo', $tipo);
        }

        if($taglia != 'Taglia') {
            $qb = $qb
                ->andWhere('s.name = (:taglia)')
                ->setParameter('taglia', $taglia);
        }

        return $qb->getQuery()->getResult();

    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
