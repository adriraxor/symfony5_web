<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @property  paginator
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Produit::class);
        $this->paginator = $paginator;
    }

    /**
     * @return int|mixed|string
     * Cette méthode retourne les 5 derniers produits récemment ajoutés au catalogue
     */
    public function findOneMostRecentProduct(){
        return $this->createQueryBuilder("p")
            ->setMaxResults(1)
            ->orderBy('p.dateApparition', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $date
     * @return int|mixed|string
     * Cette méthode retourne la liste de tous les produits qui vont prochainement sortir
     */
    public function findAllComingSoonProduct($date)
    {
        return $this->createQueryBuilder("p")
            ->setMaxResults(9)
            ->where('p.dateApparition > \'' . $date . '\'')
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


    /**
     * Récupère les produits en fonction d'une recherche
     * @param SearchData $search
     * @param $date
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search, $date): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('p')
            ->where('p.dateApparition < \'' . $date . '\'')
            ->select('c', 'p')
            ->join('p.id_categorie', 'c');



        if(!empty($search->keyword)){
            $query = $query
                ->andWhere('p.nomProduit LIKE :keyword')
                ->setParameter('keyword', "%{$search}%");
        }

        if(!empty($search->min_price)){
            $query = $query
                ->andWhere('p.tarifProduit >= :min_price')
                ->setParameter('min_price', $search->min_price);
        }

        if(!empty($search->max_price)){
            $query = $query
                ->andWhere('p.tarifProduit <= :max_price')
                ->setParameter('max_price', $search->max_price);
        }

        if(!empty($search->categories)){
            $query = $query
                ->andWhere('c.idCategorie IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }


}
