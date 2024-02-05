<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\OffreRepository;
use App\Repository\TransactionRepository;
use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'app_payment')]
    public function index(
        StripeService $stripeService,
        OffreRepository $offres,
        ClientRepository $clients,
        TransactionRepository $transactions
        ): Response
    {

        $apiKey = $this->getParameter('STRIPE_API_KEY_SECRET'); // Clé API secrète
        $offre = $offres->findOneBy(['id' => 5]); // Offre à vendre (titre et montant)
        $clientEmail = $clients->findOneBy(['id' => 9])->getEmail();

        $link = $stripeService->makePayment(
            $apiKey,
            $offre->getMontant(),
            $offre->getTitre(),
            $clientEmail
        );

        return $this->redirect($link);

        // return $this->render('payment/index.html.twig', [
        //     'controller_name' => 'PaymentController',
        // ]);
    }

    #[Route('/success', name: 'payment_success')]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}