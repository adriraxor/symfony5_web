<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="mon_profil", methods={"GET","POST"})
     * @param ClientRepository $clientRepository
     * @param CommandeRepository $commandeRepository
     * @return Response
     */
    public function index(ClientRepository $clientRepository, CommandeRepository $commandeRepository): Response
    {

        $client_em = $clientRepository->findAll();
        $commande_em = $commandeRepository->findAll();
        $user = $this->getUser();

        return $this->render('mon_profil/index.html.twig', [
            'controller_name' => 'MonProfilController',
            'clients' => $client_em,
            'commandes' => $commande_em,
            'users' => $user,
        ]);
    }
}
