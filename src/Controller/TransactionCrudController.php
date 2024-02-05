<?php

namespace App\Controller;

use App\Entity\Transaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TransactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transaction::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::DETAIL, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            AssociationField::new('client', 'Client de la transaction'),
            TextField::new('statut', 'Statut de la transaction'),
            DateField::new('date', 'Date de la transaction')
                ->setFormat('dd-MM-yyyy')
                ->hideOnForm(),
            DateField::new('createdAt', 'Créé le')
                ->setFormat('dd-MM-yyyy')
                ->hideOnIndex(),
            DateField::new('updatedAt', 'Mis à jour le')
                ->setFormat('dd-MM-yyyy')
                ->hideOnIndex(),
            MoneyField::new('montant', 'Montant de la transaction')
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
        ];
    }
}
