<?php

namespace App\Controller;

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
     * @return Response
     */
    public function index(ProduitRepository $produitRepository): Response
    {

        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date

        $em = $this->getDoctrine()->getManager();

        $query_carroussel = 'SELECT AVG(note_produit) AS Note_Jeu, image FROM commentaire_produit cp INNER JOIN produit p ON cp.id_produit = p.idProduit GROUP BY idProduit ORDER BY Note_Jeu DESC LIMIT 3;';
        $statement_carroussel = $em->getConnection()->prepare($query_carroussel);


        $query_tendance = 'SELECT AVG(note_produit) AS Note_Jeu, image FROM commentaire_produit cp INNER JOIN produit p ON cp.id_produit = p.idProduit GROUP BY idProduit ORDER BY Note_Jeu DESC LIMIT 5;';
        $statement_tendance = $em->getConnection()->prepare($query_tendance);


        $statement_carroussel->execute();
        $statement_tendance->execute();

        $result_carroussel = $statement_carroussel->fetchAll();
        $result_tendance = $statement_tendance->fetchAll();


        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits_populaire_carroussel' => $result_carroussel,
            'produits_populaire_top5' => $result_tendance,
            'produits_recent' => $produitRepository->findOneMostRecentProduct($dateVue),
            'produits_soon' => $produitRepository->findAllComingSoonProduct($dateVue),
        ]);
    }


}
