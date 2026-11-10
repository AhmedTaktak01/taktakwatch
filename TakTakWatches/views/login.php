<?php
// ============================================
// Vue : Page de connexion
// ============================================
$pageTitle = "Connexion - Taktak Watches";
require __DIR__ . '/layout/header.php';
?>

        <div class="container">
            <!-- Section image -->
            <section class="image-section">
                <img src="background.jpg" alt="Image de connexion élégante">
            </section>

            <!-- Section formulaire de connexion -->
            <section class="login-section">
                <div class="login-header">
                    <h1>Connexion</h1>
                    <p>Bienvenue! Connectez-vous à votre compte</p>
                </div>

                <!-- Formulaire avec action vers le contrôleur -->
                <form method="post" action="index.php?page=process_login">
                    <!-- Champ Nom d'utilisateur -->
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    </div>

                    <!-- Lien mot de passe oublié -->
                    <div class="forgot-password">
                        <a href="#reset">Mot de passe oublié?</a>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" class="submit-btn">Se Connecter</button>
                </form>

                <!-- Connexion alternative via réseaux sociaux -->
                <article class="alternative-login">
                    <p>Ou connectez-vous avec</p>
                    <div class="social-login">
                        <a href="https://www.facebook.com" target="_blank" rel="noopener" class="social-btn" aria-label="Se connecter avec Facebook">
                            <i class="fa-brands fa-facebook" style="font-size: 20px; color: #1877f2;"></i>
                        </a>
                        <a href="https://www.google.com" target="_blank" rel="noopener" class="social-btn" aria-label="Se connecter avec Google">
                            <i class="fa-brands fa-google" style="font-size: 20px; color: #db4437;"></i>
                        </a>
                        <a href="https://www.twitter.com" target="_blank" rel="noopener" class="social-btn" aria-label="Se connecter avec Twitter">
                            <i class="fa-brands fa-twitter" style="font-size: 20px; color: #1da1f2;"></i>
                        </a>
                    </div>
                </article>

                <!-- Lien vers création de compte -->
                <div class="create-account">
                    <p>Pas encore de compte? <a href="index.php?page=signup">Créer un compte</a></p>
                </div>
            </section>
        </div>

        <!-- Section avantages du compte -->
        <section style="padding: 50px 20px; background-color: #f9f9f9;">
            <h2 style="text-align: center; margin-bottom: 30px;">Avantages d'un Compte Taktak</h2>
            <div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; max-width: 1000px; margin: 0 auto;">
                <article style="background: white; padding: 30px; border-radius: 8px; flex: 1; min-width: 250px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-truck" style="font-size: 40px; color: gold; margin-bottom: 15px;"></i>
                    <h3>Livraison Suivie</h3>
                    <p>Suivez vos commandes en temps réel</p>
                </article>
                <article style="background: white; padding: 30px; border-radius: 8px; flex: 1; min-width: 250px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-gift" style="font-size: 40px; color: gold; margin-bottom: 15px;"></i>
                    <h3>Offres Exclusives</h3>
                    <p>Accédez à des promotions réservées aux membres</p>
                </article>
                <article style="background: white; padding: 30px; border-radius: 8px; flex: 1; min-width: 250px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <i class="fa-solid fa-heart" style="font-size: 40px; color: gold; margin-bottom: 15px;"></i>
                    <h3>Liste de Souhaits</h3>
                    <p>Sauvegardez vos montres préférées</p>
                </article>
            </div>
        </section>

<?php require __DIR__ . '/layout/footer.php'; ?>
