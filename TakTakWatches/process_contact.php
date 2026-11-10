<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($email) || empty($message)) {
        die("Veuillez remplir tous les champs.");
    }

    $stmt = $conn->prepare("INSERT INTO contacts (email, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Message envoyé avec succès! Nous vous répondrons bientôt.'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Erreur: " . $stmt->error . "'); window.location.href='contact.html';</script>";
    }

    $stmt->close();
}
$conn->close();
?>
