<?php
// ============================================
// Contrôleur : ProductController
// ============================================
// Gère l'affichage public des produits, la recherche multicritères,
// et le CRUD admin avec upload d'images

require_once __DIR__ . '/../classes/ProductManager.php';
require_once __DIR__ . '/../classes/Uploader.php';

class ProductController {
    private ProductManager $productManager;

    public function __construct() {
        $this->productManager = new ProductManager();
    }

    /**
     * Afficher la page publique des produits avec recherche multicritères
     * Utilise $_GET pour les critères de recherche
     */
    public function index(): void {
        // Récupérer les critères de recherche depuis $_GET
        $searchName  = $_GET['search_name'] ?? '';
        $searchType  = $_GET['search_type'] ?? '';
        $searchMin   = $_GET['min_price'] ?? '';
        $searchMax   = $_GET['max_price'] ?? '';

        $isSearching = !empty($searchName) || !empty($searchType) || !empty($searchMin) || !empty($searchMax);

        if ($isSearching) {
            $products = $this->productManager->search(
                !empty($searchName) ? $searchName : null,
                !empty($searchType) ? $searchType : null,
                !empty($searchMin) ? (float)$searchMin : null,
                !empty($searchMax) ? (float)$searchMax : null
            );
        } else {
            $products = $this->productManager->getAllPublic();
        }

        require __DIR__ . '/../views/products.php';
    }

    /**
     * Page d'administration des produits
     * Affiche le formulaire et la liste des produits
     */
    public function admin(): void {
        // Vérifier l'authentification et les droits admin
        if (empty($_SESSION['is_admin'])) {
            $_SESSION['error'] = "Accès refusé. Privilèges administrateur requis.";
            header('Location: index.php?page=home');
            exit();
        }

        // Mode édition ?
        $editProduct = null;
        if (isset($_GET['edit'])) {
            $editProduct = $this->productManager->findById(intval($_GET['edit']));
        }

        $products = $this->productManager->getAll();
        require __DIR__ . '/../views/admin_products.php';
    }

    /**
     * Traiter le formulaire d'ajout/modification de produit ($_POST + $_FILES)
     */
    public function save(): void {
        if (empty($_SESSION['is_admin'])) {
            $_SESSION['error'] = "Accès refusé. Privilèges administrateur requis.";
            header('Location: index.php?page=home');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=admin_products');
            exit();
        }

        $id    = $_POST['id'] ?? '';
        $name  = trim($_POST['name'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $type  = $_POST['type'] ?? 'Classique';
        $description = trim($_POST['description'] ?? '');
        $stock = isset($_POST['is_out_of_stock']) ? 1 : 0;

        // Gestion de l'upload d'image via $_FILES
        $imageName = $_POST['current_image'] ?? 'watch1.jpg';

        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            try {
                $uploader = new Uploader();
                $imageName = $uploader->upload($_FILES['image_file']);
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur d'upload : " . $e->getMessage();
                header('Location: index.php?page=admin_products');
                exit();
            }
        }

        if ($id) {
            // Mise à jour
            $product = $this->productManager->findById(intval($id));
            if ($product) {
                $product->setName($name);
                $product->setPrice($price);
                $product->setType($type);
                $product->setDescription($description);
                $product->setImage($imageName);
                $product->setIsOutOfStock($stock);
                $this->productManager->update($product);
                $_SESSION['success'] = "Produit modifié avec succès.";
            }
        } else {
            // Création
            $product = new Product($name, $price, $description, null, $imageName, $type, $stock);
            $this->productManager->create($product);
            $_SESSION['success'] = "Produit ajouté à la collection.";
        }

        header('Location: index.php?page=admin_products');
        exit();
    }

    /**
     * Supprimer un produit via $_GET['delete']
     */
    public function delete(): void {
        if (empty($_SESSION['is_admin'])) {
            $_SESSION['error'] = "Accès refusé. Privilèges administrateur requis.";
            header('Location: index.php?page=home');
            exit();
        }

        if (isset($_GET['id'])) {
            $this->productManager->delete(intval($_GET['id']));
            $_SESSION['success'] = "Produit supprimé de la collection.";
        }

        header('Location: index.php?page=admin_products');
        exit();
    }
}
