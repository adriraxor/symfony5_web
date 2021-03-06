<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\CommentaireProduit;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="mon_profil", methods={"GET","POST"})
     * @param Client $client
     * @param ClientRepository $clientRepository
     * @param CommandeRepository $commandeRepository
     * @param Request $request
     * @return Response
     */
    public function index(Client $client, ClientRepository $clientRepository, CommandeRepository $commandeRepository, Request $request): Response
    {
        $client_em = $clientRepository->findAll();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $query = 'SELECT image, nom_produit, qte, tarif_produit, date_commande, montant_total FROM ligne_commande lc INNER JOIN commande c ON lc.Id_Commande = c.id INNER JOIN produit p ON lc.Id_Produit = p.idProduit INNER JOIN client cl ON c.id_client_id = cl.id WHERE cl.id = '.$client->getId().' LIMIT 9;';
        $statement_query = $em->getConnection()->prepare($query);

        $statement_query->execute();
        $result_query = $statement_query->fetchAll();

        return $this->render('mon_profil/index.html.twig', [
            'controller_name' => 'MonProfilController',
            'clients' => $client_em,
            'commandes' => $result_query,
            'users' => $user,
        ]);
    }

    /**
     * @Route("/update/{id}", name="profil_update", methods={"GET","POST"})
     * @param $id
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, EntityManagerInterface $em, Request $request)
    {
        //Pour r??cup??rer les valeurs d'un POST (important si l'on veut la valeur d'un textarea, d'un select ou autres...)
        $quest = $request->request->all();

        //Je r??cup??re le repo client pour pouvoir r??cup??rer l'id du client qui est connect?? ?? son compte
        $getClientRepo = $em->getRepository("App:Client");
        $user = $getClientRepo->find($id);

        foreach($quest as $prop=>$qst) {
            if ($user instanceof Client) {
                $color_picker = $_POST['color_picker']; //Je r??cup??re la valeur du color_picker
                $user->setStyleCouleurProfil($color_picker); //Je met ?? jour le style du profil
                //Et on envoie dans la database le nouveau style
                $em->persist($user);
                $em->flush();
            }
        }
        //On actualise notre page "mon_profil" en quelque sorte on va lorsque le traitement ?? ??t?? effectu?? pr??c??demment redirigez vers la page "mon_profil" en passant comme param??tre l'ID du client connect?? qui a effectu?? le changement de style couleur
        return $this->redirectToRoute('mon_profil', array('id' => $id));
    }
}
