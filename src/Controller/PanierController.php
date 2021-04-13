<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Creer;
use App\Entity\Facture;
use App\Entity\LigneCommande;
use App\Entity\Vente;
use App\Repository\CategorieRepository;
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
     */
    public function moins($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []); //Si je n'ai pas de panier j'affiche un tableau vide

        $panier[$id]--;


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
     * @Route("/checkout/{id}", name="panier_checkout")
     * @param SessionInterface $session
     * @param ProduitRepository $produitRepository
     * @return string
     */
    public function checkout(SessionInterface $session, ProduitRepository $produitRepository): string
    {

        $uuid = Uuid::v4();
        $date = new \DateTime();

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

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $dateVue = date_format($date, 'd-m-Y H:i');

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('panier/checkout.html.twig', [
            'title' => "Facture achat",
            'items' => $panierAvecProduits,
            'uuid'=> $uuid,
            'user'=>$user,
            'total' => $total,
            'date'=>$dateVue,
        ]);

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

        $ligneCommande = new LigneCommande();
        $ligneCommande->setIdProduit($item['produit']);
        $ligneCommande->setIdCommande($commande);
        $ligneCommande->setQte($item['quantity']);
        $ligneCommande->setTarif($totalItem);

        $sql = $this->getDoctrine()->getManager();
        $sql->persist($ligneCommande);
        $sql->flush();

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


    }

}
