<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Json;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }


    /**
     * Les routes pour l'API concernant les produits
     */

    /**
     * @Route("/ApiAllProducts", name="api_all_products")
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function webServiceAllProducts(ProduitRepository $produitRepository): Response
    {
        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date

        $lesProduits=  $produitRepository->findAllProductAPI($dateVue);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesProduits, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/ApiAllRecentProducts", name="api_all_recent_products")
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function webServiceAllRecentProducts(ProduitRepository $produitRepository): Response
    {

        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date

        $lesProduits=  $produitRepository->findAllRecentProductAPI($dateVue);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesProduits, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiAllTendanceProducts", name="api_all_tendance_products")
     * @return Response
     */
    public function webServiceAllTendanceProducts(): Response
    {

        $em = $this->getDoctrine()->getManager();

        $query_tendance = 'SELECT nom_produit, libelle, tarif_produit, stock, AVG(note_produit) AS Note_Jeu, nom_categorie, date_apparition, image FROM commentaire_produit cp INNER JOIN produit p ON cp.id_produit = p.idProduit INNER JOIN categorie c ON p.Id_Categorie = c.Id_Categorie GROUP BY idProduit ORDER BY Note_Jeu DESC LIMIT 5;';
        $statement_tendance = $em->getConnection()->prepare($query_tendance);

        $statement_tendance->execute();
        $result_tendance = $statement_tendance->fetchAll();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($result_tendance, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiAllCommingSoonProducts", name="api_all_comming_products")
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function webServiceAllCommingSoonProducts(ProduitRepository $produitRepository): Response
    {

        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date

        $lesProduits=  $produitRepository->findAllCommingSoonProductsAPI($dateVue);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesProduits, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiCountTotalProducts", name="api_count_total_products")
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function webServiceCountTotalProducts(ProduitRepository $produitRepository): Response
    {

        $lesProduits=  $produitRepository->findCountTotalProductsAPI();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesProduits, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiValueStockProducts", name="api_value_stock_products")
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function webServiceValueStockProducts(ProduitRepository $produitRepository): Response
    {

        $lesProduits=  $produitRepository->findValueStockAPI();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesProduits, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * Les routes pour l'API concernant les clients
     * /!\ Les routes concernants les clients seront privées à certaines personnes /!\
     * /!\ Il est important de garder privée les données confidentielles des clients c'est pour cela que uniquement certaines personnes pourrons acceder via l'API à ces données /!\
     * /!\ Le mot de passe malgrés qu'il soit hash ne sera pas retourné ! /!\
     */
    /**
     * @Route("/ApiAllClients", name="api_all_clients")
     * @param ClientRepository $clientRepository
     * @return Response
     */
    public function webServiceAllClients(ClientRepository $clientRepository): Response
    {

        $lesClients=  $clientRepository->findAllClientsAPI();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesClients, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiNbClientsInscrits", name="api_nb_clients_inscrit")
     * @param ClientRepository $clientRepository
     * @return Response
     */
    public function webServiceNbClientsInscrits(ClientRepository $clientRepository): Response
    {

        $lesClients=  $clientRepository->findNbClientInscritsAPI();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($lesClients, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/ApiNbClientsCommandes", name="api_nb_clients_commandes")
     * @param CommandeRepository $commandeRepository
     * @return Response
     */
    public function webServiceNbClientsCommandes(CommandeRepository $commandeRepository): Response
    {

        $NbClientCommande=  $commandeRepository->findNbClientCommandeAPI();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($NbClientCommande, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
