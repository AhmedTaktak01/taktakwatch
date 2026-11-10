<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - Taktak Watches</title>
    <link rel="icon" type="image/x-icon" href="Logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/013baba51d.js" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    
    <!-- CSS inline requis pour le projet -->
    <style>
        /* Styles spécifiques à la page produits */
        .products-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 20px;
            text-align: center;
            color: white;
        }
        
        .filter-section {
            background-color: #f5f5f5;
            padding: 30px;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .filter-btn {
            padding: 10px 20px;
            margin: 5px;
            border: 2px solid #333;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 5px;
            font-weight: 500;
        }
        
        .filter-btn:hover {
            background: #333;
            color: white;
            transform: translateY(-2px);
        }

        /* Styles pour le tableau de comparaison */
        .comparison-table {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background: white;
        }

        .comparison-table caption {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            padding: 15px;
        }

        .comparison-table thead {
            background: linear-gradient(135deg, #333 0%, #555 100%);
            color: white;
        }

        .comparison-table th {
            padding: 18px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
        }

        .comparison-table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
            color: #555;
        }

        .comparison-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .comparison-table tbody tr:hover {
            background-color: #fff3cd;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .comparison-table tfoot {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
        }

        .comparison-table tfoot td {
            padding: 15px;
            text-align: center;
            border-top: 3px solid #333;
        }

        /* Badge pour le type de montre */
        .type-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .type-connectee {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .type-classique {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .type-plongee {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .type-sport {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav>
            <div class="navlinks">
                <img src="Logo.png" alt="Logo Taktak Watches" width="50px">
                <a href="index.html">Accueil</a>
                <a href="#all-products">Produits</a>
                <a href="login.html">Compte</a>
                <a href="contact.html">Contact</a>
                <a href="https://www.rolex.com" target="_blank" rel="noopener">Rolex Officiel</a>
            </div>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main>
        <!-- Section Hero -->
        <section class="products-hero">
            <h1 style="font-size: 48px; margin-bottom: 20px;">Notre Collection Complète</h1>
            <p style="font-size: 20px;">Découvrez l'excellence horlogère</p>
        </section>

        <!-- Section de filtrage -->
        <section class="filter-section">
            <h3 style="margin-bottom: 20px; font-size: 24px; color: #333;">Filtrer par catégorie</h3>
            <button class="filter-btn" onclick="alert('Filtre: Toutes les montres')">Toutes</button>
            <button class="filter-btn" onclick="alert('Filtre: Montres connectées')">Connectées</button>
            <button class="filter-btn" onclick="alert('Filtre: Montres classiques')">Classiques</button>
            <button class="filter-btn" onclick="alert('Filtre: Montres sport')">Sport</button>
            <button class="filter-btn" onclick="alert('Filtre: Montres luxe')">Luxe</button>
        </section>

        <!-- Section catalogue complet -->
        <section class="catalogue" id="all-products">
            <h2>Toutes Nos Montres</h2>
            
            <div class="card-container">
                <?php
                require_once 'db.php';
                $result = $conn->query("SELECT * FROM products ORDER BY id ASC");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<article class="card">';
                        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                        echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                        if (!empty($row['old_price']) && $row['old_price'] > 0) {
                            echo '<p style="text-decoration: line-through; color: gray;">' . number_format($row['old_price'], 2) . ' TND</p>';
                            echo '<p style="color: red; font-weight: bold;">' . number_format($row['price'], 2) . ' TND</p>';
                        } else {
                            echo '<p style="font-size: 20px; font-weight: bold; color: #333;">' . number_format($row['price'], 2) . ' TND</p>';
                        }
                        
                        if ($row['is_out_of_stock']) {
                            echo '<button class="btn-out" disabled>Rupture de Stock</button>';
                        } else {
                            echo '<button class="btn-view" onclick="alert(\'✓ Produit ajouté au panier!\')">Ajouter au Panier</button>';
                        }
                        echo '</article>';
                    }
                } else {
                    echo "<p>Aucun produit n'a été trouvé.</p>";
                }
                ?>
            </div>
        </section>

        <!-- Section avec liste non ordonnée -->
        <section style="padding: 50px 20px; background-color: white; max-width: 1000px; margin: 0 auto;">
            <h2 style="text-align: center; margin-bottom: 30px; font-size: 32px; color: #333;">Avantages de nos Montres</h2>
            <article style="background: #f9f9f9; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 20px; color: #333;">Pourquoi choisir Taktak Watches?</h3>
                <ul style="list-style-type: disc; padding-left: 40px; line-height: 2; color: #555;">
                    <li><strong style="color: #333;">Qualité Premium:</strong> Matériaux de haute qualité pour une durabilité exceptionnelle</li>
                    <li><strong style="color: #333;">Garantie Étendue:</strong> Jusqu'à 5 ans de garantie sur certains modèles</li>
                    <li><strong style="color: #333;">Service Client 24/7:</strong> Une équipe dédiée à votre satisfaction</li>
                    <li><strong style="color: #333;">Livraison Rapide:</strong> Expédition en 24-48h partout en Tunisie</li>
                    <li><strong style="color: #333;">Prix Compétitifs:</strong> Les meilleurs prix du marché sans compromis sur la qualité</li>
                    <li><strong style="color: #333;">Large Sélection:</strong> Plus de 100 modèles différents en stock</li>
                    <li><strong style="color: #333;">Paiement Sécurisé:</strong> Transactions 100% sécurisées et cryptées</li>
                </ul>
            </article>
        </section>

        <!-- Section tableau de comparaison des modèles -->
        <section style="padding: 50px 20px; background-color: #f5f5f5;">
            <h2 style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333;">Comparez Nos Best-Sellers</h2>
            
            <!-- TABLEAU HTML COMPLET AVEC TOUTES LES BALISES REQUISES -->
            <table class="comparison-table">
                <!-- Caption pour décrire le tableau -->
                <caption>Tableau Comparatif des Modèles Populaires 2025</caption>
                
                <!-- En-tête du tableau -->
                <thead>
                    <tr>
                        <th>Modèle</th>
                        <th>Type</th>
                        <th>Étanchéité</th>
                        <th>Autonomie</th>
                        <th>Garantie</th>
                        <th>Prix (TND)</th>
                    </tr>
                </thead>
                
                <!-- Corps du tableau avec les données -->
                <tbody>
                    <tr>
                        <td><strong>ENZO BRO-BLACK</strong></td>
                        <td><span class="type-badge type-connectee">Connectée</span></td>
                        <td>5 ATM (50m)</td>
                        <td>3-5 jours</td>
                        <td>2 ans</td>
                        <td style="color: red; font-weight: bold;">260,100</td>
                    </tr>
                    <tr>
                        <td><strong>Daniel Wellington</strong></td>
                        <td><span class="type-badge type-classique">Classique</span></td>
                        <td>3 ATM (30m)</td>
                        <td>Pile 2 ans</td>
                        <td>2 ans</td>
                        <td style="font-weight: bold;">631,59</td>
                    </tr>
                    <tr>
                        <td><strong>Rolex Sea-Dweller</strong></td>
                        <td><span class="type-badge type-plongee">Plongée</span></td>
                        <td>100 ATM (1000m)</td>
                        <td>Automatique</td>
                        <td>5 ans</td>
                        <td style="font-weight: bold;">2663,52</td>
                    </tr>
                    <tr>
                        <td><strong>Casio G-Shock</strong></td>
                        <td><span class="type-badge type-sport">Sport</span></td>
                        <td>20 ATM (200m)</td>
                        <td>Pile 10 ans</td>
                        <td>1 an</td>
                        <td style="font-weight: bold;">450,00</td>
                    </tr>
                    <tr>
                        <td><strong>Apple Watch S9</strong></td>
                        <td><span class="type-badge type-connectee">Connectée</span></td>
                        <td>5 ATM (50m)</td>
                        <td>18 heures</td>
                        <td>1 an</td>
                        <td style="font-weight: bold;">1250,00</td>
                    </tr>
                    <tr>
                        <td><strong>TAG Heuer Carrera</strong></td>
                        <td><span class="type-badge type-classique">Classique</span></td>
                        <td>10 ATM (100m)</td>
                        <td>Automatique</td>
                        <td>2 ans</td>
                        <td style="font-weight: bold;">2100,00</td>
                    </tr>
                </tbody>
                
                <!-- Pied du tableau avec note importante -->
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <i class="fa-solid fa-info-circle" style="color: gold; margin-right: 8px;"></i>
                            Tous les prix incluent la TVA | Garantie constructeur | Livraison gratuite en Tunisie
                        </td>
                    </tr>
                </tfoot>
            </table>
            
            <!-- Légende pour les badges -->
            <div style="text-align: center; margin-top: 25px; padding: 20px;">
                <p style="font-size: 16px; color: #666; margin-bottom: 15px;"><strong>Légende des types:</strong></p>
                <span class="type-badge type-connectee" style="margin: 5px;">Connectée</span>
                <span class="type-badge type-classique" style="margin: 5px;">Classique</span>
                <span class="type-badge type-plongee" style="margin: 5px;">Plongée</span>
                <span class="type-badge type-sport" style="margin: 5px;">Sport</span>
            </div>
        </section>

        <!-- Section liens utiles -->
        <aside style="padding: 40px 20px; background-color: white; text-align: center;">
            <h3 style="margin-bottom: 20px; font-size: 24px; color: #333;">Liens Utiles</h3>
            <nav>
                <a href="#all-products" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-arrow-up"></i> Retour aux produits
                </a> |
                <a href="index.html" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-home"></i> Page d'accueil
                </a> |
                <a href="contact.html" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-envelope"></i> Nous contacter
                </a> |
                <a href="https://www.watchtime.com" target="_blank" rel="noopener" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-external-link"></i> Magazine WatchTime
                </a>
            </nav>
        </aside>
    </main>

    <!-- Pied de page -->
    <footer class="footer" role="contentinfo">
        <div class="social">
            <h3 class="sr-only">Suivez-nous</h3>
            <a href="https://www.facebook.com" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://www.twitter.com" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="https://www.instagram.com" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.youtube.com" target="_blank" rel="noopener" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <hr class="footer-break">
        <ul class="footer-links">
            <li><a href="index.html">ACCUEIL</a></li>
            <li><a href="products.html">PRODUITS</a></li>
            <li><a href="login.html">COMPTE</a></li>
            <li><a href="contact.html">CONTACT</a></li>
        </ul>
        <p class="copyright">© 2025 Taktak Watches. Tous droits réservés</p>
    </footer>
</body>
</html>