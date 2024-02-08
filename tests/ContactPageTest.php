<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactPageTest extends WebTestCase
{
    public function testContactPage(): void
    {
        self::ensureKernelShutdown();
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $adminUser = $userRepository->findOneBy(['email' => 'admin@admin.fr']);
        $client->loginUser($adminUser);
        $client->request('GET', '/contact');
        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('html');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Contact');
        $this->assertSelectorTextContains('h2', 'Support technique');
    }
}