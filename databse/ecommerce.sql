CREATE DATABASE ecommerce;
USE ecommerce;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


INSERT INTO users (username, email, password, role) 
VALUES ('Yoan', 'yoanlable@gmail.com', '$2y$10$Q0jdFA0yI0P.ykdKuFmphOWfh8EwR0.pVuibUaX7sfv9F.yZZGMya', 'admin');
echo password_hash('adminpassword', PASSWORD_BCRYPT);


/* === Test === */
INSERT INTO users (username, email, password) 
VALUES 
('gildas', 'gildas@gmail.com', '$2y$10$fKASgvxCXnC8F4zEYyPApuJbqNNDzF5VeUfeQaUe0WpoD25M0kdMu'),
('bini', 'bini@gmail.com', '$2y$10$lkJLm0Q08lwN.hIBuXOnWegPX3kCIZEt9wVX7lt5zl6k.8bwVmmSa');


/* === Plan du Projet === */
ecommerce/
├── backend/
│   ├── config/
│   │   ├── config.php         # Configuration de la base de données
│   │   ├── routes/            # Endpoints API
│   │   │   ├── auth.php       # Authentification (login/register)
│   │   │   ├── users.php      # Gestion des utilisateurs
│   │   │   ├── products.php   # Gestion des produits
│   │   │   ├── orders.php     # Gestion des commandes
│   │   │   └── payments.php   # Gestion des paiements
│   ├── uploads/               # Stockage des images des produits
│   │   ├── [uploaded images]
│   ├── controllers/           # Logique métier
│   │   ├── UserController.php # Gère les utilisateurs
│   │   ├── ProductController.php # Gère les produits
│   │   ├── OrderController.php   # Gère les commandes
│   │   └── PaymentController.php # Gère les paiements
│   ├── models/                # Modèles pour interagir avec la base de données
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── Payment.php
│   ├── index.php              # Point d'entrée principal du backend
│   ├── .env                   # Variables sensibles pour le backend
├── frontend/
│   ├── public/
│   │   ├── index.html         # Point d'entrée principal React
│   │   ├── favicon.ico        # Icône de la page
│   │   └── assets/
│   │       ├── css/           # Fichiers CSS globaux
│   │       │   ├── Global.css
│   │       │   ├── Navbar.css
│   │       │   ├── Footer.css
│   │       └── img/           # Images statiques
│   │           ├── logo.png
│   │           ├── banner.jpg
│   │           └── [other images]
│   ├── src/
│   │   ├── components/        # Composants React
│   │   │   ├── Home.js        # Page d'accueil
│   │   │   ├── Products.js    # Liste des produits
│   │   │   ├── Cart.js        # Panier
│   │   │   ├── AdminPanel.js  # Gestion administrative
│   │   │   ├── PaymentPage.js # Paiement
│   │   │   ├── OrderHistory.js # Historique des commandes
│   │   │   ├── StudentsList.js # Liste des utilisateurs pour admin
│   │   │   └── Login.js       # Connexion
│   │   ├── App.js             # Composant principal React
│   │   ├── index.js           # Point d'entrée React
│   │   └── Styles/            # Dossier pour le CSS des composants spécifiques
│   │       ├── Products.css
│   │       ├── Cart.css
│   │       ├── Payment.css
│   │       ├── AdminPanel.css
│   │       ├── StudentsList.css
│   │       └── Global.css     # Styles globaux
├── .env                       # Variables sensibles pour configurer les chemins et clés
├── package.json               # Dépendances npm pour le frontend
├── README.md                  # Documentation du projet
└── database.sql               # Script SQL pour la base de données



