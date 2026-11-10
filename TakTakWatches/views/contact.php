<?php
// ============================================
// Vue : Page de contact
// ============================================
$pageTitle = "Contact - Taktak Watches";
require __DIR__ . '/layout/header.php';
?>

        <div class="container">
            <!-- Section image -->
            <div class="image-section">
                <img src="background.jpg" alt="Image de contact">
            </div>

            <!-- Section formulaire -->
            <section class="login-section">
                <div class="login-header">
                    <h1>Contactez-Nous</h1>
                    <p>Nous sommes là pour vous aider. Envoyez-nous un message!</p>
                </div>

                <!-- Formulaire avec action vers le contrôleur -->
                <form method="post" action="index.php?page=process_contact">
                    <!-- Champ Email -->
                    <div class="form-group">
                        <label for="email">Adresse Email <span style="color: red;">*</span></label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.com" required>
                    </div>

                    <!-- Champ Message -->
                    <div class="form-group">
                        <label for="message">Votre Message <span style="color: red;">*</span></label>
                        <textarea id="message" name="message" placeholder="Écrivez votre message ici..." rows="5" required></textarea>
                    </div>

                    <!-- Bouton de soumission -->
                    <button type="submit" class="submit-btn">Envoyer le Message</button>
                </form>

                <!-- Informations de contact supplémentaires -->
                <aside class="contact-info" style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
                    <h3 style="margin-bottom: 15px;">Autres Moyens de Contact</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;">
                            <i class="fa-solid fa-phone" style="color: gold; margin-right: 10px;"></i>
                            <strong>Téléphone:</strong> +216 28 800 649
                        </li>
                        <li style="margin-bottom: 10px;">
                            <i class="fa-solid fa-envelope" style="color: gold; margin-right: 10px;"></i>
                            <strong>Email:</strong> taktakahmed10@gmail.com
                        </li>
                        <li style="margin-bottom: 10px;">
                            <i class="fa-solid fa-location-dot" style="color: gold; margin-right: 10px;"></i>
                            <strong>Adresse:</strong> Avenue Habib Bourguiba, Tunis, Tunisie
                        </li>
                        <li style="margin-bottom: 10px;">
                            <i class="fa-solid fa-clock" style="color: gold; margin-right: 10px;"></i>
                            <strong>Horaires:</strong> Lun-Sam: 9h-18h
                        </li>
                    </ul>
                </aside>

                <!-- Liste ordonnée des étapes -->
                <article style="margin-top: 30px;">
                    <h3>Comment nous contacter en 3 étapes:</h3>
                    <ol style="padding-left: 20px; line-height: 2;">
                        <li>Remplissez le formulaire ci-dessus avec vos informations</li>
                        <li>Décrivez votre demande ou question en détail</li>
                        <li>Cliquez sur "Envoyer le Message" et nous vous répondrons dans les 24h</li>
                    </ol>
                </article>

                <!-- Lien de retour -->
                <div style="text-align: center; margin-top: 20px;">
                    <a href="index.php?page=home#about" style="color: gold; text-decoration: none; font-weight: bold;">
                        ← Retour à la page À Propos
                    </a>
                </div>
            </section>
        </div>

        <!-- Section FAQ -->
        <section class="faq-section" style="padding: 50px 20px; background-color: #f0f0f0;">
            <h2 style="text-align: center; margin-bottom: 30px;">Questions Fréquemment Posées</h2>
            <div style="max-width: 800px; margin: 0 auto;">
                <article style="background: white; padding: 20px; margin-bottom: 15px; border-radius: 8px;">
                    <h4 style="color: #333;">Quel est le délai de livraison?</h4>
                    <p style="color: #666;">Nos délais de livraison varient entre 2-7 jours selon votre formule choisie.</p>
                </article>
                <article style="background: white; padding: 20px; margin-bottom: 15px; border-radius: 8px;">
                    <h4 style="color: #333;">Proposez-vous une garantie?</h4>
                    <p style="color: #666;">Oui, toutes nos montres sont garanties de 1 à 5 ans selon le modèle.</p>
                </article>
                <article style="background: white; padding: 20px; margin-bottom: 15px; border-radius: 8px;">
                    <h4 style="color: #333;">Puis-je retourner ma montre?</h4>
                    <p style="color: #666;">Vous disposez de 14 jours pour retourner votre produit s'il ne vous convient pas.</p>
                </article>
            </div>
        </section>

        <!-- Carte Google Maps -->
        <section style="padding: 50px 20px; text-align: center;">
            <h2 style="margin-bottom: 20px;">Notre Localisation</h2>
            <div style="max-width: 800px; margin: 0 auto;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3274.676221159099!2d10.754659075827902!3d34.83923237287089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13002ccf556879ed%3A0x2cc57d3508fd754f!2sInternational%20School%20of%20Business!5e0!3m2!1sfr!2stn!4v1765748472391!5m2!1sfr!2stn"
                    width="100%" height="400" style="border:0; border-radius: 30px;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </section>

<?php require __DIR__ . '/layout/footer.php'; ?>
