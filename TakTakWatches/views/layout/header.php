<?php
// ============================================
// Layout : Header partagé
// ============================================
// Inclus dans toutes les vues pour le header et navigation
// Utilise $_SESSION pour affichage conditionnel
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'TakTak Watches'; ?></title>
    <link rel="icon" type="image/x-icon" href="Logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/013baba51d.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <?php if (isset($extraStyles)): ?>
    <style><?php echo $extraStyles; ?></style>
    <?php endif; ?>
</head>
<body>
    <!-- En-tête avec navigation -->
    <header>
        <nav>
            <div class="navlinks">
                <img src="Logo.png" alt="Logo Taktak Watches" width="50px">
                <a href="index.php?page=home">Accueil</a>
                <a href="index.php?page=products">Produits</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <a href="index.php?page=admin_products">Dashboard</a>
                    <?php endif; ?>
                    <a href="index.php?page=logout">Déconnexion (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                <?php else: ?>
                    <a href="index.php?page=login">Compte</a>
                <?php endif; ?>
                <a href="index.php?page=contact">Contact</a>
                <a href="https://en.wikipedia.org/wiki/Rolex" target="_blank" rel="noopener">Wiki</a>
            </div>
        </nav>
    </header>

    <!-- Messages flash (succès / erreur) -->
    <?php if (isset($_SESSION['success'])): ?>
    <div style="background: rgba(46,204,113,0.15); color: #2ECC71; text-align: center; padding: 12px; font-size: 0.9rem; letter-spacing: 1px; border-bottom: 1px solid rgba(46,204,113,0.3);">
        <i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(231,76,60,0.15); color: #E74C3C; text-align: center; padding: 12px; font-size: 0.9rem; letter-spacing: 1px; border-bottom: 1px solid rgba(231,76,60,0.3);">
        <i class="fa-solid fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
    <?php endif; ?>

    <main>
