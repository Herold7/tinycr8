<?php

namespace App\Tests;

use App\Repository\ClientRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentTest extends WebTestCase
{
    /**
     * Ce test nous montre comment mettre en place la vérification du statut de la réponse
     * suite à une requête HTTP. Ici, on vérifie que le statut de la réponse est bien 200.
     * Cependant, cette route étant protégée par un firewall, on doit se connecter avant de se
     * rendre sur cette page. Pour cela, on utilise fait appel au repository concerné
     * puis on le connecte avec la méthode loginUser() du client HTTP de WebTestCase
     */
    public function testPaymentRouteWhenLoggedIn(): void
    {
        self::ensureKernelShutdown(); // On coupe le kernel s'il est déjà démarré
        $client=static::createClient();// instance d'un client HTTP
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneBy(['email'=>'admin@admin.fr']);
        $client->loginUser($adminUser); //On se connecte en tant qu'admin
        $client->request('GET', '/payment/');// Cible envoie une requete HTTP - Pensez au "/" final si pas de parametres de l'URL
        $this->assertResponseStatusCodeSame(
            200); //vérifie que la réponse HTTP est un succès (200)
    }
}
