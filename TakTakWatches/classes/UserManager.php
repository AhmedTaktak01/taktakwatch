<?php
// ============================================
// Classe DAO : UserManager
// ============================================
// Gère les opérations CRUD pour l'entité User
// Utilise des requêtes préparées (PDO) pour la sécurité

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';

class UserManager {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Rechercher un utilisateur par son nom d'utilisateur
     * @param string $username
     * @return User|null
     */
    public function findByUsername(string $username): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();

        if ($row) {
            return new User(
                $row['username'],
                $row['email'],
                $row['password'],
                $row['is_admin'] ?? 0,
                $row['id'],
                $row['created_at']
            );
        }
        return null;
    }

    /**
     * Rechercher un utilisateur par son ID
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return new User(
                $row['username'],
                $row['email'],
                $row['password'],
                $row['is_admin'] ?? 0,
                $row['id'],
                $row['created_at']
            );
        }
        return null;
    }

    /**
     * Créer un nouvel utilisateur
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)"
        );
        return $stmt->execute([
            ':username' => $user->getUsername(),
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':is_admin' => $user->getIsAdmin(),
        ]);
    }

    /**
     * Récupérer tous les utilisateurs
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        $users = [];
        while ($row = $stmt->fetch()) {
            $users[] = new User(
                $row['username'],
                $row['email'],
                $row['password'],
                $row['is_admin'] ?? 0,
                $row['id'],
                $row['created_at']
            );
        }
        return $users;
    }

    /**
     * Supprimer un utilisateur par son ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
