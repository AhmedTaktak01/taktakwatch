<?php
// ============================================
// Contrôleur : AuthController
// ============================================
// Gère l'authentification : connexion, inscription, déconnexion
// Utilise $_SESSION et $_POST

require_once __DIR__ . '/../classes/UserManager.php';

class AuthController {
    private UserManager $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    /**
     * Afficher la page de connexion
     */
    public function loginPage(): void {
        require __DIR__ . '/../views/login.php';
    }

    /**
     * Traiter le formulaire de connexion ($_POST)
     */
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=login');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: index.php?page=login');
            exit();
        }

        $user = $this->userManager->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            // Connexion réussie : stocker les infos en session
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['is_admin'] = $user->getIsAdmin();

            $_SESSION['success'] = "Connexion réussie! Bienvenue, " . htmlspecialchars($user->getUsername()) . ".";
            header('Location: index.php?page=home');
            exit();
        } else {
            $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
            header('Location: index.php?page=login');
            exit();
        }
    }

    /**
     * Afficher la page d'inscription
     */
    public function signupPage(): void {
        require __DIR__ . '/../views/signup.php';
    }

    /**
     * Traiter le formulaire d'inscription ($_POST)
     */
    public function signup(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=signup');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: index.php?page=signup');
            exit();
        }

        if (strlen($username) < 3) {
            $_SESSION['error'] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
            header('Location: index.php?page=signup');
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Veuillez entrer une adresse email valide.";
            header('Location: index.php?page=signup');
            exit();
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = "Le mot de passe doit contenir au moins 6 caractères.";
            header('Location: index.php?page=signup');
            exit();
        }

        // Vérifier si l'utilisateur existe déjà
        $existing = $this->userManager->findByUsername($username);
        if ($existing) {
            $_SESSION['error'] = "Ce nom d'utilisateur est déjà pris.";
            header('Location: index.php?page=signup');
            exit();
        }

        // Créer l'utilisateur avec mot de passe haché (is_admin forcé à 0 pour un compte basique)
        $user = new User($username, $email, password_hash($password, PASSWORD_DEFAULT), 0);

        if ($this->userManager->create($user)) {
            // Connexion automatique après inscription
            $newUser = $this->userManager->findByUsername($username);
            $_SESSION['user_id'] = $newUser->getId();
            $_SESSION['username'] = $newUser->getUsername();
            $_SESSION['is_admin'] = $newUser->getIsAdmin();

            $_SESSION['success'] = "Inscription réussie! Bienvenue, " . htmlspecialchars($username) . ".";
            header('Location: index.php?page=home');
            exit();
        } else {
            $_SESSION['error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            header('Location: index.php?page=signup');
            exit();
        }
    }

    /**
     * Déconnexion — Détruire la session
     */
    public function logout(): void {
        session_unset();
        session_destroy();
        // Redémarrer la session pour le message flash
        session_start();
        $_SESSION['success'] = "Vous avez été déconnecté avec succès.";
        header('Location: index.php?page=login');
        exit();
    }
}
