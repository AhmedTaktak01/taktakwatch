<?php
// ============================================
// Contrôleur : ContactController
// ============================================
// Gère la soumission du formulaire de contact
// et l'affichage/suppression admin des messages

require_once __DIR__ . '/../classes/ContactManager.php';

class ContactController {
    private ContactManager $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
    }

    /**
     * Afficher la page de contact
     */
    public function index(): void {
        require __DIR__ . '/../views/contact.php';
    }

    /**
     * Traiter le formulaire de contact ($_POST)
     */
    public function submit(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=contact');
            exit();
        }

        $email   = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($email) || empty($message)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header('Location: index.php?page=contact');
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Veuillez entrer une adresse email valide.";
            header('Location: index.php?page=contact');
            exit();
        }

        $contact = new Contact($email, $message);

        if ($this->contactManager->create($contact)) {
            $_SESSION['success'] = "Message envoyé avec succès! Nous vous répondrons bientôt.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'envoi du message.";
        }

        header('Location: index.php?page=contact');
        exit();
    }

    /**
     * Page d'administration des messages
     */
    public function admin(): void {
        if (empty($_SESSION['is_admin'])) {
            $_SESSION['error'] = "Accès refusé. Privilèges administrateur requis.";
            header('Location: index.php?page=home');
            exit();
        }

        $contacts = $this->contactManager->getAll();
        $totalMessages = $this->contactManager->count();
        require __DIR__ . '/../views/admin_contact.php';
    }

    /**
     * Supprimer un message via $_GET['id']
     */
    public function delete(): void {
        if (empty($_SESSION['is_admin'])) {
            $_SESSION['error'] = "Accès refusé. Privilèges administrateur requis.";
            header('Location: index.php?page=home');
            exit();
        }

        if (isset($_GET['id'])) {
            $this->contactManager->delete(intval($_GET['id']));
            $_SESSION['success'] = "Message supprimé.";
        }

        header('Location: index.php?page=admin_contact');
        exit();
    }
}
