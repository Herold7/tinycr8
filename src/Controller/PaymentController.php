<?php

namespace App\Controller;

use App\Form\PaymentType;
use App\Entity\Transaction;
use App\Service\StripeService;
use Symfony\Component\Mime\Email;
use App\Repository\OffreRepository;
use App\Repository\ClientRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/', name: 'app_payment')]
    public function index(
        Request $request,
        StripeService $stripeService,
        OffreRepository $offres,
        ClientRepository $clients,
        MailerInterface $mailer,
        EntityManagerInterface $em,
        TransactionRepository $transaction
    ): Response {

        $form = $this->createForm(PaymentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $offre = $offres->findOneBy(['id' => $data['offre']->getId()]); // Offre à vendre (titre et montant);
            $client = $clients->findOneBy(['id' => $data['client']->getId()]);
            $apiKey = $this->getParameter('STRIPE_API_KEY_SECRET'); // Clé API secrète
            $link = $stripeService->makePayment(
                $apiKey,
                $offre->getMontant(),
                $offre->getTitre(),
                $client->getEmail()
            );
            // Envoie du lien au client
            $email = (new Email())
                ->from('hello@tynicrm.app')
                ->to($client->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Merci de procéder au paiement de votre offre')
                ->html('<div style="background-color: #F4F4F4; padding: 20px; text-align: center;">
            <h1>Bonjour ' . $client->getPrenom() .' !</h1><br><br>
            <p>Voici le lien afin d\'effectuer le paiement de votre offre :</p><br>
            <a href="' . $link . '"}" target="_blank">Payer</a><br>
            <hr>
            <p>Ce lien est valable pour une durée limitée.</p><br>
            </div>
            ');
            $mailer->send($email);

            //Flash messsage

            $transaction = new Transaction();
            $transaction->setClient($data['client'])
            ->addOffre($offre)
            ->setMontant($offre->getMontant())
            ->setStatut('En attente')
            ;
            $em->persist($transaction); // EntityManagerInterface
            $em->flush();
        }

        return $this->render('payment/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/success', name: 'payment_success')]
    public function success(
        TransactionRepository $transactions,
        EntityManagerInterface $em
    ): Response
    {
// $stripe = new \Stripe\StripeClient('sk_test_...');
// $endpoint_secret = 'whsec_c4c298b2018308154744a9cd9e9d60af46c16d2697f157f698795c34a2de945c';
// $payload = @file_get_contents('php://input');
// $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
// $event = null;

//         try {
//             $event = \Stripe\Webhook::constructEvent(
//                 $payload,
//                 $sig_header,
//                 $endpoint_secret
//             );
//         } catch (\UnexpectedValueException $e) {
//             // Invalid payload
//             http_response_code(400);
//             exit();
//         } catch (\Stripe\Exception\SignatureVerificationException $e) {
//             // Invalid signature
//             http_response_code(400);
//             exit();

//             switch ($event->type) {
//                 case 'payment_intent.succeeded':
//                     $paymentIntent = $event->data->object;
//                     // ... handle other event types
//                 default:
//                     echo 'Received unknown event type ' . $event->type;
//             }

// http_response_code(200);

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
