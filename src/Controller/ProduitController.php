<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\CommentaireProduit;
use App\Entity\Produit;
use App\Form\FiltreForm;
use App\Form\Produit1Type;
use App\Form\SearchForm;
use App\Repository\CommentaireProduitRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{

    /**
     * @Route("/", name="produit_index", methods={"GET"})
     * @param ProduitRepository $produitRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProduitRepository $produitRepository, Request $request): Response
    {

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'Y-m-d H:i:s'); //on définis le format 24h pour la date
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $produits = $produitRepository->findSearch($data, $dateVue);

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idproduit}", name="produit_show", methods={"GET"})
     * @param Produit $produit
     * @param CommentaireProduitRepository $commentaireProduitRepository
     * @param Request $request
     * @return Response
     */
    public function show(Produit $produit, CommentaireProduitRepository $commentaireProduitRepository, Request $request): Response
    {

        $data = new CommentaireProduit();
        $data->page = $request->get('page', 1);

        return $this->render('produit/show.html.twig', [
            'commentaires' => $commentaireProduitRepository->findAllComment($data,$produit), /* On affiche tous les commentaires pour le produit en question */
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{idproduit}/edit", name="produit_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Produit $produit
     * @return Response
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idproduit}", name="produit_delete", methods={"DELETE"})
     * @param Request $request
     * @param Produit $produit
     * @return Response
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getIdproduit(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        return $this->redirectToRoute('produit_index');
    }

    /**
     * @Route("/{idproduit}", name="produit_comment", methods={"GET","POST"})
     * @param Request $request
     * @param Produit $produit
     * @return Response
     */
    public function commentaire(Request $request, Produit $produit): Response
    {
        date_default_timezone_set('Europe/Paris'); //On définis le fusiaux horaire
        $input = $_POST['commentaire_produit']; //On récupère le champ textarea qui contiens l'avis utilisateur
        $note = $_POST['note_produit'];
        $date = new DateTime(); //On créer un nouvel objet de type dateTime
        $dateVue = date_format($date, 'd-m-Y H:i'); //on définis le format 24h pour la date
        $client = $this->getUser(); //On récupère les informations de l'User connecté

        $cmpd = new CommentaireProduit(); //On créer un nouvel objet CommentaireProduit
        $cmpd->setMessage($input); //On set le message a partir de l'input
        $cmpd->setNoteProduit($note);
        $cmpd->setDate($dateVue); //On set la date a partir de DateTime
        $cmpd->setIdClient($client); //on set le Id du client a partir de la récupération de l'Id du client connecté
        $cmpd->setIdProduit($produit); //on set l'id du produit a partir du produit sur lequel a été écris le message (ex : 5 = Mario kart)

        //Procédure pour insérer dans la base de données
        $sql = $this->getDoctrine()->getManager();
        $sql->persist($cmpd);
        $sql->flush();

        //On actualise en redirigant vers la même page
        return $this->redirect($request->getUri());
    }





}
