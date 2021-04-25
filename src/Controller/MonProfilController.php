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

        return $this->render('mon_profil/index.html.twig', [
            'controller_name' => 'MonProfilController',
            'clients' => $client_em,
            'commandes' => $commandeRepository->findAllCommandsByUser($client),
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
        //Pour récupérer les valeurs d'un POST (important si l'on veut la valeur d'un textarea, d'un select ou autres...)
        $quest = $request->request->all();

        //Je récupére le repo client pour pouvoir récupérer l'id du client qui est connecté à son compte
        $getClientRepo = $em->getRepository("App:Client");
        $user = $getClientRepo->find($id);

        foreach($quest as $prop=>$qst) {
            if ($user instanceof Client) {
                $color_picker = $_POST['color_picker']; //Je récupére la valeur du color_picker
                $user->setStyleCouleurProfil($color_picker); //Je met à jour le style du profil
                //Et on envoie dans la database le nouveau style
                $em->persist($user);
                $em->flush();
            }
        }
        //On actualise notre page "mon_profil" en quelque sorte on va lorsque le traitement à été effectué précédemment redirigez vers la page "mon_profil" en passant comme paramètre l'ID du client connecté qui a effectué le changement de style couleur
        return $this->redirectToRoute('mon_profil', array('id' => $id));
    }
}
