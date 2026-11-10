<?php
// ============================================
// Classe Utilitaire : Uploader
// ============================================
// Gère l'upload sécurisé de fichiers (images)
// Vérifie le type, la taille, et génère un nom unique

require_once __DIR__ . '/../config.php';

class Uploader {
    private string $uploadDir;
    private int $maxSize;
    private array $allowedExtensions;

    /**
     * Constructeur
     * @param string|null $uploadDir Répertoire de destination (par défaut : uploads/)
     */
    public function __construct(?string $uploadDir = null) {
        $this->uploadDir = $uploadDir ?? UPLOAD_DIR;
        $this->maxSize = MAX_UPLOAD_SIZE;
        $this->allowedExtensions = ALLOWED_EXTENSIONS;

        // Créer le répertoire uploads/ s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Effectuer l'upload d'un fichier
     * Utilise $_FILES pour récupérer le fichier envoyé
     *
     * @param array $file Le tableau $_FILES['nom_du_champ']
     * @return string Le nom du fichier uploadé
     * @throws Exception En cas d'erreur d'upload
     */
    public function upload(array $file): string {
        // Vérifier les erreurs d'upload PHP
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors de l'upload du fichier (code : {$file['error']}).");
        }

        // Vérifier la taille du fichier
        if ($file['size'] > $this->maxSize) {
            $maxMB = $this->maxSize / (1024 * 1024);
            throw new Exception("Le fichier est trop volumineux. Taille maximale : {$maxMB} Mo.");
        }

        // Vérifier l'extension du fichier
        $originalName = $file['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->allowedExtensions)) {
            $allowed = implode(', ', $this->allowedExtensions);
            throw new Exception("Extension non autorisée. Extensions acceptées : {$allowed}.");
        }

        // Vérifier le type MIME réel du fichier
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ];

        if (!in_array($mimeType, $allowedMimes)) {
            throw new Exception("Type de fichier non autorisé. Seules les images sont acceptées.");
        }

        // Générer un nom de fichier unique pour éviter les collisions
        $newFileName = uniqid('img_', true) . '.' . $extension;
        $destination = $this->uploadDir . $newFileName;

        // Déplacer le fichier temporaire vers le répertoire de destination
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Impossible de déplacer le fichier uploadé.");
        }

        return $newFileName;
    }

    /**
     * Supprimer un fichier uploadé
     * @param string $filename Le nom du fichier à supprimer
     * @return bool
     */
    public function delete(string $filename): bool {
        $filePath = $this->uploadDir . $filename;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}
