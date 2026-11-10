<?php
// ============================================
// Configuration centralisée du projet
// ============================================

// Paramètres de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'taktak_watches');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Paramètres de l'application
define('BASE_URL', '/TakTakWatches/');
define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
