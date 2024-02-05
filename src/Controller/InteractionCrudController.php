<?php

namespace App\Controller;

use App\Entity\Interaction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class InteractionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Interaction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Les interactions')
            ->setPageTitle('new', 'Ajouter une interaction')
            ->setPageTitle('edit', 'Modifier une interaction')
            ->setPageTitle('detail', 'Détails de l\'interaction')
            ->setTimezone('Europe/Paris')
            ->setSearchFields(['type', 'date'])
            ->setDefaultSort(['date' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            ChoiceField::new('type')->setChoices([
                'Appel téléphonique' => 'Appel téléphonique',
                'Email' => 'Email',
                'Rendez-vous' => 'Rendez-vous',
                'Visite' => 'Visite',
                'Réunion' => 'Réunion',
                'Visioconférence' => 'Visioconférence',
                'SMS' => 'SMS',
            ]),
            TextareaField::new('commentaires', 'Commentaires')
                ->setHelp('Ce champs contient les commentaires de l\'interaction'),
            DateField::new('date', 'Date de l\'interaction')
                ->setFormat('dd/MM/yyyy'),
            DateField::new('createdAt', 'Créé le')
                ->setFormat('dd/MM/yyyy')
                ->onlyOnDetail(),
            DateField::new('updatedAt', 'Mis à jour le')
                ->setFormat('dd/MM/yyyy')
                ->onlyOnDetail()
        ];
    }
}
