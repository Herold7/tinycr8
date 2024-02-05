<?php

namespace App\Controller;

use App\Entity\Offre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OffreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offre::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Nos offres')
            ->setPageTitle('new', 'Ajouter une offre')
            ->setPageTitle('edit', 'Modifier une offre')
            ->setPageTitle('detail', 'Détails de l\'offre')
            ->setTimezone('Europe/Paris')
            ->setSearchFields(['titre', 'description']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('titre', 'Totre de l\'offre')
                ->setHelp('Ce champs contient le titre de l\'offre'),
            TextareaField::new('description', 'Description de l\'offre')
                ->setHelp('Ce champs contient la description de l\'offre'),
            MoneyField::new('montant', 'Montant de l\'offre')
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
            DateField::new('createdAt', 'Créé le')
                ->setFormat('dd/MM/yyyy')
                ->onlyOnDetail(),
            DateField::new('updatedAt', 'Mis à jour le')
                ->setFormat('dd/MM/yyyy')
                ->onlyOnDetail()
        ];
    }
}
