<?php
// ============================================
// Classe Entité : User
// ============================================
// Représente un utilisateur du système

class User {
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $is_admin;
    private ?string $created_at;

    public function __construct(
        string $username = '',
        string $email = '',
        string $password = '',
        int $is_admin = 0,
        ?int $id = null,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->is_admin = $is_admin;
        $this->created_at = $created_at;
    }

    // --- Getters ---
    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getIsAdmin(): int { return $this->is_admin; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // --- Setters ---
    public function setId(?int $id): void { $this->id = $id; }
    public function setUsername(string $username): void { $this->username = $username; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setIsAdmin(int $is_admin): void { $this->is_admin = $is_admin; }
    public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }
}
