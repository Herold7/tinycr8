# Setup de l'environnement de test

Tout est dans la documentation : 

[Testing in Symfony](https://symfony.com/doc/current/testing.html#set-up-your-test-environment)

## Initialisez la base de données de test

Tout d'abord renseignez la variable d'environnement `DATABASE_URL` dans le fichier `.env.test.local` pour la base de données de test et ajoutez le suffixe `-test` au nom de la base de données.

```bash
symfony console doctrine:database:create --env=test
symfony console doctrine:schema:create --env=test
```

## Excutez les tests sur la BDD avec les fixtures

```bash
symfony console doctrine:fixtures:load --env=test
```

## Créer un premier test

```bash
symfony console make:test
```

Choisissez la catégorie `WebTestCase` pour les tests fonctionnels. Nous allons tester les contrôleurs, et en particulier les routes protégées par le firewall qui nécessitent une authentification.

Le nom de la classe de test doit se terminer par `Test` pour être reconnue par PHPUnit. Mais symfony-cli le fait pour vous en cas d'oubli.

Rendez-vous dans le ficher PaymentTest.php pour voir la suite.