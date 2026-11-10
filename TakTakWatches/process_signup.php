<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die("Veuillez remplir tous les champs.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        echo "<script>alert('Inscription réussie!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Erreur: " . $stmt->error . "'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
