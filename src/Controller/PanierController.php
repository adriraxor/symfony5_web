<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Creer;
use App\Entity\Facture;
use App\Entity\Inclure;
use App\Entity\LigneCommande;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Vente;
use App\Repository\CategorieRepository;
use App\Repository\FactureRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     * @param SessionInterface $session
     * @param ProduitRepository $produitRepository
     * @return Response
     */
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {

        $panier = $session->get('panier', []);

        $panierAvecProduits = [];
        foreach ($panier as $id => $quantity) {
            $panierAvecProduits[] = [
                'produit' => $produitRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierAvecProduits as $item) {
            $totalItem = $item['produit']->getTarifProduit() * $item['quantity'];
            $total += $totalItem;
        }



        return $this->render('panier/index.html.twig', [
            'items' => $panierAvecProduits,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []); //Si je n'ai pas de panier j'affiche un tableau vide

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);


        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []); //Si je n'ai pas de panier j'affiche un tableau vide

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute("panier");

    }

    /**
     * @Route("/panier/moins/{id}", name="panier_moins")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function moins($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []); //Si je n'ai pas de panier j'affiche un tableau vide

        $panier[$id]--;
        if($panier[$id] < 1){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");

    }

    /**
     * @Route("/panier/plus/{id}", name="panier_plus")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function plus($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []); //Si je n'ai pas de panier j'affiche un tableau vide

        $panier[$id]++;

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/traitementAchat/{id}", name="panier_traitement_achat")
     * @param $id
     * @param ProduitRepository $produitRepository
     * @param SessionInterface $session
     * @return Response
     */
    public function traitementAchat($id, ProduitRepository $produitRepository, SessionInterface $session): Response{

        $user = $this->getUser();
        $date = new \DateTime();
        $uuid = Uuid::v4();

        $dateVue = date_format($date, 'd-m-Y H:i');

        $panier = $session->get('panier', []);

        $panierAvecProduits = [];

        foreach ($panier as $id => $quantity) {
            $panierAvecProduits[] = [
                'produit' => $produitRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierAvecProduits as $item) {
            $totalItem = $item['produit']->getTarifProduit() * $item['quantity'];
            $total += $totalItem;
        }

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('panier/facturepdf.html.twig', [
            'title' => "Facture achat",
            'items' => $panierAvecProduits,
            'uuid'=> $uuid,
            'user'=>$user,
            'total' => $total,
            'date'=>$dateVue,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();


        //Traitement SQL
        $facture = new Facture();
        $facture->setNumeroFacture($uuid);
        $facture->setMontantFacture($total);
        $facture->setFacturePdf($html);

        $sql = $this->getDoctrine()->getManager();
        $sql->persist($facture);
        $sql->flush();

        $commande = new Commande();
        $commande->setIdClient($user);
        $commande->setIdFacture($facture);
        $commande->setDateCommande($dateVue);
        $commande->setMontantTotal($total);

        $sql = $this->getDoctrine()->getManager();
        $sql->persist($commande);
        $sql->flush();

        $panier = new Panier();


        foreach ($panierAvecProduits as $unPrd){
            $panier->setQte($unPrd['quantity']);
            $panier->setIdClient($user);

            $sql = $this->getDoctrine()->getManager();
            $sql->persist($panier);
            $sql->flush();
            $ligneCommande = new LigneCommande();
            $ligneCommande->setIdProduit($unPrd['produit']);
            $ligneCommande->setIdCommande($commande);
            $ligneCommande->setQte($unPrd['quantity']);
            $ligneCommande->setTarif($totalItem);

            $sql = $this->getDoctrine()->getManager();
            $sql->persist($ligneCommande);
            $sql->flush();

            //On récupère le montant de point ("Fidélité") actuel que possède le client
            $point = $user->getPointClient();
            $user->setPointClient($point = $point + $total * 2); //On met à jour le nouveau montant de point du client en se basant sur le montant de point avant achat

            $sql = $this->getDoctrine()->getManager();
            $sql->persist($user);
            $sql->flush();

            $RAW_QUERY = 'UPDATE produit SET stock = stock - 1 WHERE nom_produit = "'.$unPrd['produit'].'"';

            $em = $this->getDoctrine()->getManager();
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->execute();

            $inclure_relation = new Inclure();
            $inclure_relation->setIdProduit($unPrd['produit']);
            $inclure_relation->setIdPanier($panier);

            $sql = $this->getDoctrine()->getManager();
            $sql->persist($inclure_relation);
            $sql->flush();
        }

        //On redirige vers la page de confirmation d'achat
        return $this->redirectToRoute('panier_success');
    }

    /**
     * @Route("/successbuy", name="panier_success")
     * @param ProduitRepository $produitRepository
     * @param SessionInterface $session
     * @return Response
     */
    public function success(ProduitRepository $produitRepository, SessionInterface $session){

        $user = $this->getUser();

        $panier = $session->get('panier', []);
        $panierAvecProduits = [];

        foreach ($panier as $id => $quantity) {
            $panierAvecProduits[] = [
                'produit' => $produitRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierAvecProduits as $item) {
            $totalItem = $item['produit']->getTarifProduit() * $item['quantity'];
            $total += $totalItem;
        }



        return $this->render('panier/successbuy.html.twig', [
            'title' => "Facture achat",
            'client'=>$user
        ]);
    }

    /**
     * @Route("/facture/{id}", name="panier_facture")
     * @param SessionInterface $session
     * @param ProduitRepository $produitRepository
     * @return string
     */
    public function facture(SessionInterface $session, ProduitRepository $produitRepository): string
    {

        $user = $this->getUser();

        $uuid = Uuid::v4();
        $date = new \DateTime();

        $panier = $session->get('panier', []);
        $panierAvecProduits = [];

        foreach ($panier as $id => $quantity) {
            $panierAvecProduits[] = [
                'produit' => $produitRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierAvecProduits as $item) {
            $totalItem = $item['produit']->getTarifProduit() * $item['quantity'];
            $total += $totalItem;
        }

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $dateVue = date_format($date, 'd-m-Y H:i');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('panier/facturepdf.html.twig', [
            'title' => "Facture achat",
            'items' => $panierAvecProduits,
            'uuid'=> $uuid,
            'user'=>$user,
            'total' => $total,
            'date'=>$dateVue,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (force download)
        $dompdf->stream("facture.pdf", [
            "Attachment" => true
        ]);

        //On viens remettre le panier à 0 produit après la fin de tous le traitement précédent (L'Achat)
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        $this->redirectToRoute('accueil');

    }

}
