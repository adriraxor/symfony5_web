<?php

namespace App\Controller\Admin;

use App\Entity\CommentaireProduit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentaireProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CommentaireProduit::class;
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
                    ->setLabel("Ajouter un commentaire")
                    ->setIcon('fa fa-plus-square');
            });


    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('id_client'),
            TextField::new('message'),
            AssociationField::new('id_produit'),

        ];
    }

}
