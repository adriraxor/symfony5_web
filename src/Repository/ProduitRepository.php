<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @return int|mixed|string
     * Cette méthode retourne tous les produits qui sont en stock soit > 0
     */
    public function findAllProductInStock(){
        return $this->createQueryBuilder("p")
            ->where('p.stock > 0')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     * Cette méthode retourne les 5 derniers produits récemment ajoutés au catalogue
     */
    public function findAllRecentProduct(){
        return $this->createQueryBuilder("p")
            ->setMaxResults(5)
            ->orderBy('p.dateApparition', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     * Cette méthode retourne les 5 derniers produits récemment ajoutés au catalogue
     */
    public function findOneMostPopularProduct(){
        return $this->createQueryBuilder("p")
            ->setMaxResults(3)
            ->orderBy('p.popularite')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     * Cette méthode retourne tous les produits
     */
    public function findAllProducts(){
        return $this->createQueryBuilder("p")
            ->getQuery()
            ->getResult();
    }




    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
