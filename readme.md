# Projet Symfony Site E-Commerce
 
## Description
Ce projet est un site e-commerce développé avec le framework Symfony dans le cadre de l'évaluation finale du module PHP. Il permet aux utilisateurs de s'inscrire, de se connecter, d'acheter et de vendre des articles, ainsi que de gérer un panier d'achat. Un espace administrateur permet également la gestion des utilisateurs et des articles.
 
---
 
## Prérequis
Avant de commencer, assurez-vous d'avoir les logiciels suivants installés sur votre machine :
 
- **PHP 8.3**
- **Composer** ([Télécharger ici](https://getcomposer.org/download/))
- **Symfony CLI** ([Télécharger ici](https://symfony.com/download))
- **SQLite** (ou un autre SGBD selon votre choix)
- **Git**
- **DBeaver/TablePlus** (Optionnel, pour la gestion de la base de données)
 
---
 
## Installation du projet
### 1. Cloner le projet
```bash
git clone https://github.com/danyGhassan/symfony_project.git
cd symfony_project
```
 
### 2. Installer les dépendances
```bash
composer install
```
 
### 3. Configurer l'environnement
Créer un fichier `.env.local` à la racine du projet et y ajouter :
```yaml
DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
```
 
### 4. Initialiser la base de données
```bash
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migrations:migrate
```
 
### 5. Démarrer le serveur Symfony
```bash
symfony server:start
```
 
Le projet sera accessible sur `http://localhost:8000`
 
---
 
## Fonctionnalités principales
- **Gestion des utilisateurs** : Inscription, connexion, et modification du profil.
- **Catalogue d'articles** : Affichage avec pagination.
- **Système de vente** : Ajout et gestion d'articles par les utilisateurs.
- **Gestion du panier** : Ajout, modification, validation et facturation.
- **Espace administrateur** : Gestion des utilisateurs et des articles.
 
---
 
## Base de données
Le projet repose sur les tables suivantes :
- `User` : Stocke les informations des utilisateurs.
- `Article` : Contient les détails des articles mis en vente.
- `Cart` : Associe les articles au panier d'un utilisateur.
- `Stock` : Gère les stocks des articles.
- `Invoice` : Stocke les informations de facturation.
 
Un fichier SQL (`php_exam_db.sql`) est inclus pour générer la base de données.
 
---
 
## Contrôleurs Symfony et Pages
Le projet est structuré en différents **contrôleurs Symfony** correspondant aux pages demandées :
 
- `SecurityController`
  - `/register` : Inscription des utilisateurs.
  - `/login` : Connexion des utilisateurs.
  - Gestion automatique de la session.
 
- `HomeController`
  - `/` : Page d'accueil affichant les 4 derniers articles.
 
- `ArticleController`
  - `/articles` : Liste paginée de tous les articles.
  - `/sell` : Page pour mettre en vente un nouvel article.
  - `/detail/{id}` : Affichage des détails d'un article.
  - `/edit/{id}` (POST) : Modification ou suppression d'un article (seulement par son créateur ou un administrateur).
 
- `CartController`
  - `/cart` : Affichage du panier.
  - `/cart/validate` : Validation du panier et génération de la facture.
 
- `UserController`
  - `/account` : Affichage du compte utilisateur.
  - Gestion des articles achetés et publiés.
  - Modification des informations personnelles.
  - Possibilité d'ajouter de l'argent au solde utilisateur.
 
- `AdminController`
  - `/admin` : Tableau de bord administrateur.
  - Gestion des utilisateurs et articles (modification/suppression).
 
---
 
## Déploiement
Pour déployer le projet sur un serveur, adaptez la configuration de la base de données dans `.env.local` et utilisez un serveur compatible avec Symfony.
 
---
 
## Accès et Rôles
- Un utilisateur non connecté peut uniquement accéder aux pages **Home** et **Detail**.
- Toutes les autres pages nécessitent une authentification.
- L'accès à `/admin` est réservé aux administrateurs.