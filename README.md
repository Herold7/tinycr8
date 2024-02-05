# Note de cadrage pour le Projet de Fin d'Études CDA

## Introduction

Le présent document vise à définir le cadre d'un projet de fin d'études CDA (Conception et Développement d'Applications) intitulé "TinyCRM". Ce projet a pour objectif de concevoir et développer une application de type CRM (Customer Relationship Management) destinée aux agences SMMA (Social Media Marketing Agency).

## Technologies

- Symfony 7
- SQLite

## Description du Projet

### TinyCRM

TinyCRM est une application CRM conçue spécifiquement pour répondre aux besoins des agences SMMA. Elle offre une solution complète pour la gestion du parcours de prospection, la gestion des offres de l'agence, la facturation via Stripe, ainsi que la rédaction d'articles pour le référencement  web. L'application vise à simplifier et optimiser les processus de gestion clientèle pour les petites agences, favorisant ainsi leur productivité et leur croissance.

## Cible

### Agences SMMA (Solopreneur et TPE)

TinyCRM est conçu pour les agences SMMA, qu'elles soient dirigées par des solopreneurs ou des TPE. En s'adaptant à la taille de ces entreprises, l'application vise à fournir une solution efficace et abordable pour la gestion de la relation client, de la prospection à la facturation.

## Fonctionnalités Principales

1. **Gestion du Parcours de Prospection**
   - Suivi du parcours d'un prospect qualifié.
   - Enregistrement des interactions, des préférences et des besoins du prospect.

2. **Gestion des Offres de l'Agence**
   - Création et gestion d'offres personnalisées.
   - Suivi des propositions envoyées aux clients potentiels.

3. **Facturation avec Stripe**
   - Intégration de la plateforme Stripe pour la gestion des transactions financières.
   - Création et suivi des factures.

4. **Rédaction d'Articles Web**
   - Publication et gestion d'articles web pour le marketing de contenu.
   - Liaison des articles aux clients et aux offres de l'agence.

## Détail des Entités

### Client

Un client à un statut de "prospect" au cours de la prise de contact, puis de "signé" une fois qu'il a accepté une offre de l'agence. Un client peut être associé à plusieurs offres et factures.

| Propriété | Type              | Relation |
|-----------|-------------------|----------|
| id        | PK                | -        |
| nom       | string(50)        | -        |
| prenom    | string(50)        | -        |
| email     | string(80)        | -        |
| telephone | string(20)        | -        |
| adresse   | string(255)       | -        |
| ville     | string(50)        | -        |
| cp        | string(10)        | -        |
| pays      | string(50)        | -        |
| statut    | boolean           | -        |
| created   | datetime          | -        |
| updated   | datetime          | -        |

### Interaction

Une interaction est une entrée dans le journal de bord d'un prospect. Elle peut être de type "appel", "email", "rencontre", "message", etc. Une interaction appartient à un prospect.

| Propriété   | Type              | Relation |
|-------------|-------------------|----------|
| id          | PK                | -        |
| prospect_id | FK                | Prospect |
| type        | string(50)        | -        |
| date        | datetime          | -        |
| commentaires| text              | -        |
| created     | datetime          | -        |
| updated     | datetime          | -        |

### Offre

Une offre est une proposition commerciale envoyée à un prospect. Elle peut être associée à un ou plusieurs clients.

| Propriété   | Type              | Relation |
|-------------|-------------------|----------|
| id          | PK                | -        |
| client_id   | FK                | Client   |
| titre       | string(50)        | -        |
| description | text              | -        |
| montant     | decimal(10,2)     | -        |
| fichier     | string(255)       | -        |
| created     | datetime          | -        |
| updated     | datetime          | -        |

### Transaction (Facture)

Une transaction est une facture émise par l'agence à un client. Elle peut être associée à un client.

| Propriété   | Type              | Relation |
|-------------|-------------------|----------|
| id          | PK                | -        |
| client_id   | FK                | Client   |
| montant     | decimal(10,2)     | -        |
| date        | datetime          | -        |
| statut      | string(50)        | -        |
| created     | datetime          | -        |
| updated     | datetime          | -        |

### Article

Un article est une publication web rédigée par l'agence. Les articles sont accessibles via un endpoint public. Ils sont la plein propriété de l'agence et ne peuvent pas être associés à un client.

| Propriété   | Type              | Relation |
|-------------|-------------------|----------|
| id          | PK                | -        |
| titre       | string(50)        | -        |
| contenu     | text              | -        |
| publie      | boolean           | -        |
| created     | datetime          | -        |
| updated     | datetime          | -        |

## User Stories

### Gestion du Parcours de Prospection

Role: Membre de l'Agence (ROLE_USER)

- En tant que membre de l'agence, je veux pouvoir créer un prospect.
- En tant que membre de l'agence, je veux pouvoir consulter la liste des prospects.
- En tant que membre de l'agence, je veux pouvoir consulter le détail d'un prospect.
- En tant que membre de l'agence, je veux pouvoir modifier un prospect.
- En tant que membre de l'agence, je veux pouvoir créer une interaction pour un prospect.
- En tant que membre de l'agence, je veux pouvoir consulter la liste des interactions d'un prospect.
- En tant que membre de l'agence, je veux pouvoir consulter le détail d'une interaction.
- En tant que membre de l'agence, je veux pouvoir modifier une interaction.
- En tant que membre de l'agence, je veux pouvoir consulter la liste des offres.
- En tant que membre de l'agence, je veux pouvoir consulter le détail d'une offre.
- En tant que membre de l'agence, je veux pouvoir atttribuer une offre à un prospect.

Role: Administrateur (ROLE_ADMIN)

- En tant qu'administrateur, je veux pouvoir faire tout ce qu'un membre de l'agence peut faire.
- En tant qu'administrateur, je veux pouvoir supprimer un prospect.
- En tant qu'administrateur, je veux pouvoir supprimer une interaction.
- En tant qu'administrateur, je veux pouvoir créer une offre.
- En tant qu'administrateur, je veux pouvoir modifier une offre.
- En tant qu'administrateur, je veux pouvoir supprimer une offre.
- En tant qu'administrateur, je veux pouvoir emettre une demande de paiement pour une offre.
- En tant qu'administrateur, je veux pouvoir emettre une facture pour un prospect.