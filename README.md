# Projet E-commerce

Ce projet est une application e-commerce permettant aux utilisateurs de naviguer, acheter des produits et gérer leurs commandes.

## Fonctionnalités principales
- **Inscription et connexion** pour les utilisateurs.
- **Gestion des produits** et des utilisateurs pour les administrateurs.
- **Paiement sécurisé** via PayPal.

## Pré-requis
- PHP 8.0+
- MySQL
- Node.js et npm
- Serveur local (XAMPP ou WAMP)

## Installation
### 1. Cloner le projet ou extraire le ZIP
Téléchargez le projet via GitHub ou un fichier ZIP, puis placez-le dans votre serveur local (par ex. `htdocs/` pour XAMPP).

### 2. Importer la base de données
- Ouvrez **phpMyAdmin**.
- Créez une base de données nommée `ecommerce`.
- Importez le fichier `database/ecommerce.sql` situé dans le dossier `database/`.

### 3. Configurer le backend
- Placez le dossier `backend/` dans votre serveur local.
- Ajoutez un fichier `.env` dans `backend/` :

