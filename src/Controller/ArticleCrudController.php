<?php

namespace App\Controller;

use App\Entity\Article;
use DateTime;
use DateTimeInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des articles')
            ->setPageTitle('new', 'Ajouter un article')
            ->setPageTitle('edit', 'Modifier un article')
            ->setPageTitle('detail', 'Détails de l\'article')
            ->setSearchFields(['titre', 'contenu'])
            ->setDefaultSort(['titre' => 'ASC']);
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
            TextField::new('titre', 'Titre de l\'article')
                ->setHelp('Ce champs contient le titre de l\'article'),
            TextEditorField::new('contenu')
                ->setHelp('Ce champs contient le contenu de l\'article'),
            BooleanField::new('publie', 'Statut de publication')
                ->setHelp('Ce champs permet de publier ou non l\'article'),
            FormField::addPanel('Informations complémentaires')->onlyOnDetail(),
            DateField::new('created_at', 'Enregistré le')
                ->hideOnForm()->hideOnIndex()
                ->setFormat('dd/MM/yyyy à HH:mm:ss'),
            DateField::new('updated_at', 'Dernière modification le')
                ->hideOnIndex()->hideOnForm()->setValue(new DateTime('now'))
                ->setFormat('dd/MM/yyyy à HH:mm:ss'),
        ];
    }
}
