<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Client;
use App\Entity\Interaction;
use App\Entity\Offre;
use App\Entity\Transaction;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        return $this->render('pages/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/images/logo.png" height="40">')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Gestion de l\'activité');
        yield MenuItem::linkToCrud('Nos clients', 'fa fa-users', Client::class);
        yield MenuItem::linkToCrud('Suivi', 'fa fa-calendar', Interaction::class);
        yield MenuItem::linkToCrud('Nos offres', 'fa fa-cubes', Offre::class);
        yield MenuItem::linkToCrud('Transaction', 'fa fa-euro', Transaction::class);
        yield MenuItem::section('Gestion de contenu');
        yield MenuItem::linkToCrud('Les articles', 'fa fa-newspaper', Article::class);

        yield MenuItem::section('Paramètres');
        yield MenuItem::linkToCrud('Comptes', 'fa fa-user', User::class);
        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out');
    }
}
