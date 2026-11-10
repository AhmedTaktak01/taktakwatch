<?php
// ============================================
// Script d'initialisation de la base de données
// ============================================
// Utilise la classe Database (Singleton PDO)
// Crée la base de données, les tables, et insère les données initiales
// Ajoute un compte administrateur par défaut

// Connexion directe PDO pour créer la base si elle n'existe pas
try {
    $pdo = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Créer la base de données
    $pdo->exec("CREATE DATABASE IF NOT EXISTS taktak_watches CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Base de données 'taktak_watches' créée avec succès.\n";

    $pdo->exec("USE taktak_watches");

    // ========== Table Users ==========
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Table 'users' créée.\n";

    // ========== Table Products ==========
    $pdo->exec("CREATE TABLE IF NOT EXISTS products (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        old_price DECIMAL(10,2),
        image VARCHAR(255),
        type VARCHAR(50),
        is_out_of_stock BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Table 'products' créée.\n";

    // ========== Table Contacts ==========
    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Table 'contacts' créée.\n";

    // ========== Ajouter la colonne is_admin si elle n'existe pas ==========
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0");
        echo "✓ Colonne 'is_admin' ajoutée à la table users.\n";
    } catch (PDOException $e) {
        // La colonne existe déjà, pas de problème
        echo "→ Colonne 'is_admin' existe déjà.\n";
    }

    // ========== Insérer un administrateur par défaut ==========
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $stmt->execute([':username' => 'admin']);
    if ($stmt->fetchColumn() == 0) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)");
        $stmt->execute([
            ':username' => 'admin',
            ':email'    => 'admin@taktakwatches.com',
            ':password' => $adminPassword,
            ':is_admin' => 1,
        ]);
        echo "✓ Compte administrateur créé (admin / admin123).\n";
    } else {
        echo "→ Compte administrateur existe déjà.\n";
    }

    // ========== Insérer les produits initiaux ==========
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmt->fetchColumn() == 0) {
        $products = [
            ["ENZO BRO-BLACK", "Montre ENZO BRO-BLACK connectée", 260.10, 289.00, "watch1.jpg", "Connectée", 0],
            ["Daniel Wellington Classic", "Montre Daniel Wellington classique", 631.59, NULL, "watch2.png", "Classique", 0],
            ["Rolex Sea-Dweller", "Montre Rolex Sea-Dweller de luxe", 2663.52, NULL, "watch3.png", "Luxe", 0],
            ["Casio G-Shock Sport", "Montre Casio G-Shock sport", 450.00, NULL, "watch4.png", "Sport", 0],
            ["Omega Seamaster", "Montre Omega Seamaster", 3200.00, NULL, "watch5.jpg", "Luxe", 1],
            ["TAG Heuer Carrera", "Montre TAG Heuer Carrera", 2100.00, NULL, "watch6.jpg", "Classique", 0],
            ["Seiko Presage", "Montre Seiko Presage", 890.00, NULL, "watch7.jpg", "Classique", 0],
            ["Apple SmartWatch S9", "Apple SmartWatch S9", 1300.00, NULL, "Apple-Watch.webp", "Connectée", 0],
        ];

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, old_price, image, type, is_out_of_stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
        foreach ($products as $p) {
            $stmt->execute($p);
        }
        echo "✓ " . count($products) . " produits insérés avec succès.\n";
    } else {
        echo "→ Des produits existent déjà dans la base.\n";
    }

    echo "\n========================================\n";
    echo "✓ INITIALISATION TERMINÉE AVEC SUCCÈS !\n";
    echo "========================================\n";
    echo "Admin: admin / admin123\n";
    echo "URL: http://localhost/TakTakWatches/index.php\n";

} catch (PDOException $e) {
    echo "✗ ERREUR : " . $e->getMessage() . "\n";
}
