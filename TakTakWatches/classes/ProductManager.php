<?php
// ============================================
// Classe DAO : ProductManager
// ============================================
// Gère les opérations CRUD et la recherche multicritères
// pour l'entité Product. Utilise PDO avec requêtes préparées.

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Product.php';

class ProductManager {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Récupérer un produit par son ID
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id): ?Product {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            return $this->hydrate($row);
        }
        return null;
    }

    /**
     * Récupérer tous les produits
     * @return array
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = $this->hydrate($row);
        }
        return $products;
    }

    /**
     * Récupérer tous les produits triés par id ASC (pour affichage public)
     * @return array
     */
    public function getAllPublic(): array {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id ASC");
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = $this->hydrate($row);
        }
        return $products;
    }

    /**
     * Créer un nouveau produit
     * @param Product $product
     * @return bool
     */
    public function create(Product $product): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, description, price, old_price, image, type, is_out_of_stock)
             VALUES (:name, :description, :price, :old_price, :image, :type, :is_out_of_stock)"
        );
        return $stmt->execute([
            ':name'            => $product->getName(),
            ':description'     => $product->getDescription(),
            ':price'           => $product->getPrice(),
            ':old_price'       => $product->getOldPrice(),
            ':image'           => $product->getImage(),
            ':type'            => $product->getType(),
            ':is_out_of_stock' => $product->getIsOutOfStock(),
        ]);
    }

    /**
     * Mettre à jour un produit existant
     * @param Product $product
     * @return bool
     */
    public function update(Product $product): bool {
        $stmt = $this->db->prepare(
            "UPDATE products SET name = :name, description = :description, price = :price,
             old_price = :old_price, image = :image, type = :type, is_out_of_stock = :is_out_of_stock
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id'              => $product->getId(),
            ':name'            => $product->getName(),
            ':description'     => $product->getDescription(),
            ':price'           => $product->getPrice(),
            ':old_price'       => $product->getOldPrice(),
            ':image'           => $product->getImage(),
            ':type'            => $product->getType(),
            ':is_out_of_stock' => $product->getIsOutOfStock(),
        ]);
    }

    /**
     * Supprimer un produit par son ID
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Recherche multicritères
     * Permet de filtrer par nom, type, prix min et prix max
     *
     * @param string|null $name     Recherche partielle sur le nom
     * @param string|null $type     Filtrer par type (Connectée, Classique, Sport, Luxe, Plongée)
     * @param float|null  $minPrice Prix minimum
     * @param float|null  $maxPrice Prix maximum
     * @return array
     */
    public function search(?string $name = null, ?string $type = null, ?float $minPrice = null, ?float $maxPrice = null): array {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if (!empty($name)) {
            $sql .= " AND name LIKE :name";
            $params[':name'] = '%' . $name . '%';
        }

        if (!empty($type)) {
            $sql .= " AND type = :type";
            $params[':type'] = $type;
        }

        if ($minPrice !== null && $minPrice > 0) {
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice > 0) {
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }

        $sql .= " ORDER BY id ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = $this->hydrate($row);
        }
        return $products;
    }

    /**
     * Transformer un tableau associatif en objet Product
     * @param array $row
     * @return Product
     */
    private function hydrate(array $row): Product {
        return new Product(
            $row['name'],
            (float)$row['price'],
            $row['description'] ?? null,
            isset($row['old_price']) ? (float)$row['old_price'] : null,
            $row['image'] ?? null,
            $row['type'] ?? 'Classique',
            (int)$row['is_out_of_stock'],
            (int)$row['id'],
            $row['created_at'] ?? null
        );
    }
}
