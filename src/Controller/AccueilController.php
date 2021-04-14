<?php

namespace App\Controller;

use App\Entity\CommentaireProduit;
use App\Repository\CommentaireProduitRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    /**
     * @Route("/", name="accueil", methods={"GET"})
     * @param ProduitRepository $produitRepository
     * @param CommentaireProduit $commentaireProduit
     * @return Response
     */
    public function index(ProduitRepository $produitRepository, CommentaireProduitRepository $commentaireProduit): Response
    {

        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date

        $em = $this->getDoctrine()->getManager();
        $RAW_QUERY = 'SELECT AVG(note_produit), image FROM commentaire_produit cp INNER JOIN produit p ON cp.id_produit = p.idProduit GROUP BY idProduit;';

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();


        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits_populaire' => $result,
            'produits_recent' => $produitRepository->findOneMostRecentProduct(),
            'produits_soon' => $produitRepository->findAllComingSoonProduct($dateVue),
        ]);
    }
}
