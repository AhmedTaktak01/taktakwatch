<?php
// ============================================
// Classe DAO : ContactManager
// ============================================
// Gère les opérations CRUD pour l'entité Contact
// Utilise PDO avec requêtes préparées

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Contact.php';

class ContactManager {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupérer tous les messages de contact
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM contacts ORDER BY id DESC");
        $contacts = [];
        while ($row = $stmt->fetch()) {
            $contacts[] = new Contact(
                $row['email'],
                $row['message'],
                (int)$row['id'],
                $row['created_at']
            );
        }
        return $contacts;
    }

    /**
     * Créer un nouveau message de contact
     * @param Contact $contact
     * @return bool
     */
    public function create(Contact $contact): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO contacts (email, message) VALUES (:email, :message)"
        );
        return $stmt->execute([
            ':email'   => $contact->getEmail(),
            ':message' => $contact->getMessage(),
        ]);
    }

    /**
     * Supprimer un message par son ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM contacts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Compter le nombre total de messages
     * @return int
     */
    public function count(): int {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM contacts");
        $row = $stmt->fetch();
        return (int)$row['total'];
    }
}
