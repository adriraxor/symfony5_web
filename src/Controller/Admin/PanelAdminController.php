<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\CommentaireProduit;
use App\Entity\Facture;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanelAdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('RaxorShop [AdminSpace]');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Navigation');
        yield MenuItem::linkToRoute('Accueil', 'fa fa-external-link ', 'accueil');
        yield MenuItem::linkToRoute('Produits', 'fa fa-external-link ', 'produit_index');
        yield MenuItem::linkToRoute('Formulaire de connexion', 'fa fa-external-link ', 'app_login');
        yield MenuItem::linkToRoute('Formulaire d\'inscription', 'fa fa-external-link ', 'app_register');


        yield MenuItem::section('Gestion Administratif');

        yield MenuItem::linkToCrud('Categories', 'fas fa-code-branch', Categorie::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-box-open', Produit::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-address-card', Client::class);
        yield MenuItem::linkToCrud('Les avis utilisateurs', 'fa fa-commenting-o', CommentaireProduit::class);
        yield MenuItem::linkToCrud('Les commandes', 'fa fa-cart-arrow-down', Commande::class);
        yield MenuItem::linkToCrud('Factures', 'fas fa-file-invoice-dollar', Facture::class);



    }

}
