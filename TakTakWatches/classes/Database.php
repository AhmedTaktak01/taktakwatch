<?php
// ============================================
// Classe Database — Singleton avec PDO
// ============================================
// Gère la connexion à la base de données MySQL
// Utilise le patron de conception Singleton pour
// garantir une seule instance de connexion

require_once __DIR__ . '/../config.php';

class Database {
    // Instance unique de la classe (Singleton)
    private static ?Database $instance = null;

    // Objet PDO pour la connexion
    private PDO $pdo;

    /**
     * Constructeur privé — empêche l'instanciation directe
     * Crée la connexion PDO avec les paramètres de config.php
     */
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Empêche le clonage de l'instance (patron Singleton)
     */
    private function __clone() {}

    /**
     * Retourne l'instance unique de Database (Singleton)
     * @return Database
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Retourne l'objet PDO pour exécuter des requêtes
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->pdo;
    }
}
