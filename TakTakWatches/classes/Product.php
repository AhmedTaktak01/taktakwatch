<?php
// ============================================
// Classe Entité : Product
// ============================================
// Représente un produit (montre) du catalogue

class Product {
    private ?int $id;
    private string $name;
    private ?string $description;
    private float $price;
    private ?float $old_price;
    private ?string $image;
    private ?string $type;
    private int $is_out_of_stock;
    private ?string $created_at;

    public function __construct(
        string $name = '',
        float $price = 0.0,
        ?string $description = null,
        ?float $old_price = null,
        ?string $image = null,
        ?string $type = 'Classique',
        int $is_out_of_stock = 0,
        ?int $id = null,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->old_price = $old_price;
        $this->image = $image;
        $this->type = $type;
        $this->is_out_of_stock = $is_out_of_stock;
        $this->created_at = $created_at;
    }

    // --- Getters ---
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getOldPrice(): ?float { return $this->old_price; }
    public function getImage(): ?string { return $this->image; }
    public function getType(): ?string { return $this->type; }
    public function getIsOutOfStock(): int { return $this->is_out_of_stock; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // --- Setters ---
    public function setId(?int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setOldPrice(?float $old_price): void { $this->old_price = $old_price; }
    public function setImage(?string $image): void { $this->image = $image; }
    public function setType(?string $type): void { $this->type = $type; }
    public function setIsOutOfStock(int $is_out_of_stock): void { $this->is_out_of_stock = $is_out_of_stock; }
    public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }
}
