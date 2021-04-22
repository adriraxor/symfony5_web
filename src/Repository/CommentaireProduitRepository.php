<?php

namespace App\Repository;

use App\Entity\CommentaireProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method CommentaireProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireProduit[]    findAll()
 * @method CommentaireProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, CommentaireProduit::class);
        $this->paginator = $paginator;
    }

    /**
     * @param CommentaireProduit $cmpd
     * @param $value
     * @return int|mixed|string
     * Cette méthode retourne tous les commentaires sur le produit sélectionner par l'utilisateur
     */
    public function findAllComment(CommentaireProduit $cmpd, $value): PaginationInterface{

        //$value = 2;

        $query = $this->createQueryBuilder('cp')
            ->andWhere('cp.id_produit = :val')
            ->setParameter('val', $value)
            ->orderBy('cp.date', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->paginator->paginate(
            $query,
            $cmpd->page,
            10
        );
    }



    // /**
    //  * @return CommentaireProduit[] Returns an array of CommentaireProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentaireProduit
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
