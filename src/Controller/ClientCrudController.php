<?php

namespace App\Controller;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Nos clients')
            ->setPageTitle('new', 'Ajouter un client')
            ->setPageTitle('edit', 'Modifier un client')
            ->setPageTitle('detail', 'Détails du client')
            ->setTimezone('Europe/Paris')
            ->setSearchFields(['nom', 'prenom', 'email', 'telephone', 'adresse', 'ville', 'cp', 'pays'])
            ->setDefaultSort(['nom' => 'ASC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::DELETE, 'ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            FormField::addPanel('Informations personnelles'),
            TextField::new('nomComplet')
                ->onlyOnIndex(),
            TextField::new('nom', 'Nom du client')
                ->hideOnIndex()
                ->setHelp('Ce champs contient le nom du client'),
            TextField::new('prenom', 'Prénom du client')
                ->hideOnIndex()
                ->setHelp('Ce champs contient le prénom du client'),
            EmailField::new('email', 'E-mail du client')
                ->setHelp('Ce champs contient l\'adresse e-mail du client'),
            TextField::new('telephone', 'Téléphone du client')
                ->setHelp('Ce champs contient le numéro de téléphone du client'),
            TextField::new('adresse', 'Adresse du client')->hideOnIndex()
                ->setHelp('Ce champs contient l\'adresse du client'),
            TextField::new('ville', 'Ville')->hideOnIndex(),
            TextField::new('cp', 'Code postal')->hideOnIndex(),
            TextField::new('pays', 'Pays')->hideOnIndex(),
            BooleanField::new('statut', 'Statut du client')
                ->setHelp('Ce champs permet de définir si le client est actif ou non'),
            FormField::addPanel('Informations complémentaires'),
            DateField::new('created_at', 'Enregistré le')
                ->hideOnForm()->hideOnIndex()
                ->setFormat('dd/MM/yyyy à HH:mm:ss'),
            DateField::new('updated_at', 'Dernière modification le')
                ->hideOnIndex()
                ->setFormat('dd/MM/yyyy à HH:mm:ss'),
            MoneyField::new('totalTransactions', 'Total des transactions')
                ->setCurrency('EUR')
                ->setStoredAsCents(false)
                ->hideOnForm()
                ->hideOnIndex(),
        ];
    }
}
