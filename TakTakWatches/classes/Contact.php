<?php
// ============================================
// Classe Entité : Contact
// ============================================
// Représente un message de contact client

class Contact {
    private ?int $id;
    private string $email;
    private string $message;
    private ?string $created_at;

    public function __construct(
        string $email = '',
        string $message = '',
        ?int $id = null,
        ?string $created_at = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->message = $message;
        $this->created_at = $created_at;
    }

    // --- Getters ---
    public function getId(): ?int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getMessage(): string { return $this->message; }
    public function getCreatedAt(): ?string { return $this->created_at; }

    // --- Setters ---
    public function setId(?int $id): void { $this->id = $id; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setMessage(string $message): void { $this->message = $message; }
    public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }
}
