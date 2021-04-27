<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use Doctrine\DBAL\Types\BlobType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Configurator\ImageConfigurator;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;


class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fa fa-cog')
                    ->setLabel("Modifier")
                    ->addCssClass('btn btn-info');
            })

            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){
                return $action
                    ->setIcon('fa fa-trash')
                    ->setLabel("Supprimer");
            })

            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action){
                return $action
                    ->setLabel("Sauvegarder et continuer");
            })

            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action){
                return $action
                    ->setLabel("Sauvegarder et revenir en arrière");
            })

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action){
                return $action
                    ->setLabel("Ajouter un produit")
                    ->setIcon('fa fa-plus-square');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            //Configuration des différents champs
            ImageField::new('image') //Config du champ image
                ->setBasePath('../Images/Produits')
                ->setUploadDir('Images/Produits')
                ->setUploadedFileNamePattern('[year]-[month]-[day]_[name].[extension]'),
            TextField::new('nom_produit'), //Config du champ nom produit
            NumberField::new('tarif_produit'), // Config du champ tarif
            NumberField::new('stock'), //Config du champ stock
            TextField::new('libelle'), //Config du champ libelle
            DateTimeField::new('date_apparition'), //Config du champ date
            AssociationField::new('id_categorie'), //Config de l'association avec la catégorie
        ];
    }



}
