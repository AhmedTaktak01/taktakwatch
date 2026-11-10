<?php
// ============================================
// Front Controller / Routeur Principal
// ============================================
// Point d'entrée unique de l'application
// Route les requêtes vers les contrôleurs appropriés
// via le paramètre $_GET['page']

session_start();

// Charger les contrôleurs
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/ContactController.php';

// Récupérer la page demandée via $_GET
$page = $_GET['page'] ?? 'home';

// Instancier les contrôleurs
$authController    = new AuthController();
$productController = new ProductController();
$contactController = new ContactController();

// Routage — diriger vers le bon contrôleur et la bonne action
switch ($page) {

    // ========== Pages publiques ==========
    case 'home':
        require __DIR__ . '/views/home.php';
        break;

    case 'products':
        $productController->index();
        break;

    case 'contact':
        $contactController->index();
        break;

    // ========== Authentification ==========
    case 'login':
        $authController->loginPage();
        break;

    case 'signup':
        $authController->signupPage();
        break;

    case 'process_login':
        $authController->login();
        break;

    case 'process_signup':
        $authController->signup();
        break;

    case 'logout':
        $authController->logout();
        break;

    // ========== Formulaire de contact ==========
    case 'process_contact':
        $contactController->submit();
        break;

    // ========== Administration Produits ==========
    case 'admin_products':
        $productController->admin();
        break;

    case 'save_product':
        $productController->save();
        break;

    case 'delete_product':
        $productController->delete();
        break;

    // ========== Administration Contacts ==========
    case 'admin_contact':
        $contactController->admin();
        break;

    case 'delete_contact':
        $contactController->delete();
        break;

    // ========== Page par défaut ==========
    default:
        require __DIR__ . '/views/home.php';
        break;
}
