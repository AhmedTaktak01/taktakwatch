<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        die("Veuillez remplir tous les champs.");
    }

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            echo "<script>alert('Connexion réussie!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Mot de passe incorrect!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Utilisateur non trouvé!'); window.location.href='login.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
