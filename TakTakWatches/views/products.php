<?php
// ============================================
// Vue : Page des produits (publique)
// ============================================
// Affiche tous les produits avec recherche multicritères
// Variables injectées par ProductController : $products, $searchName, $searchType, $searchMin, $searchMax, $isSearching
$pageTitle = "Nos Produits - Taktak Watches";
$extraStyles = '
    .products-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 80px 20px;
        text-align: center;
        color: white;
    }

    /* Formulaire de recherche multicritères */
    .search-section {
        padding: 30px 20px;
        text-align: center;
        margin-bottom: 20px;
    }
    .search-form {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .search-form .form-input {
        padding: 12px 15px;
        background: rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
        color: #E0E6ED;
        font-family: "Montserrat", sans-serif;
        font-size: 0.9rem;
        border-radius: 4px;
        min-width: 180px;
        transition: border-color 0.3s;
    }
    .search-form .form-input:focus {
        outline: none;
        border-color: #D4AF37;
    }
    .search-form select.form-input { cursor: pointer; }
    .search-form .form-input::placeholder { color: #A0ABC0; }
    .search-btn {
        padding: 12px 30px;
        background: linear-gradient(135deg, #BF953F, #FCF6BA, #B38728, #FBF5B7);
        color: #000;
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(212,175,55,0.2);
    }
    .reset-btn {
        padding: 12px 20px;
        background: transparent;
        color: #E0E6ED;
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 0.85rem;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
    }
    .reset-btn:hover { border-color: #E0E6ED; background: rgba(255,255,255,0.05); }
    .search-results-info {
        text-align: center;
        padding: 15px;
        color: #D4AF37;
        font-style: italic;
        font-size: 0.95rem;
    }

    .filter-section { background-color: #f5f5f5; padding: 30px; text-align: center; margin-bottom: 40px; }
    .filter-btn {
        padding: 10px 20px; margin: 5px; border: 2px solid #333;
        background: white; cursor: pointer; transition: all 0.3s; border-radius: 5px; font-weight: 500;
    }
    .filter-btn:hover { background: #333; color: white; transform: translateY(-2px); }

    .comparison-table { width: 90%; max-width: 1000px; margin: 30px auto; border-collapse: collapse; box-shadow: 0 4px 12px rgba(0,0,0,0.15); background: white; }
    .comparison-table caption { font-size: 28px; font-weight: bold; margin-bottom: 20px; color: #333; padding: 15px; }
    .comparison-table thead { background: linear-gradient(135deg, #333 0%, #555 100%); color: white; }
    .comparison-table th { padding: 18px; text-align: center; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 14px; }
    .comparison-table td { padding: 15px; text-align: center; border-bottom: 1px solid #e0e0e0; color: #555; }
    .comparison-table tbody tr:nth-child(even) { background-color: #f9f9f9; }
    .comparison-table tbody tr:hover { background-color: #fff3cd; transform: scale(1.01); transition: all 0.3s ease; }
    .comparison-table tfoot { background-color: #f0f0f0; font-weight: bold; color: #333; }
    .comparison-table tfoot td { padding: 15px; text-align: center; border-top: 3px solid #333; }

    .type-badge { display: inline-block; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: bold; color: white; }
    .type-connectee { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .type-classique { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .type-plongee { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
    .type-sport { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
    .type-luxe { background: linear-gradient(135deg, #BF953F 0%, #FCF6BA 100%); color: #000; }
';
require __DIR__ . '/layout/header.php';
?>

        <!-- Section Hero -->
        <section class="products-hero">
            <h1 style="font-size: 48px; margin-bottom: 20px;">Notre Collection Complète</h1>
            <p style="font-size: 20px;">Découvrez l'excellence horlogère</p>
        </section>

        <!-- Section de recherche multicritères -->
        <section class="search-section">
            <h3 style="margin-bottom: 20px; font-size: 1.5rem; color: #D4AF37;">Recherche Multicritères</h3>
            <form method="GET" action="index.php" class="search-form">
                <input type="hidden" name="page" value="products">

                <input type="text" name="search_name" class="form-input"
                       placeholder="🔍 Nom du modèle..."
                       value="<?php echo htmlspecialchars($searchName ?? ''); ?>">

                <select name="search_type" class="form-input">
                    <option value="">-- Toutes catégories --</option>
                    <option value="Connectée" <?php echo ($searchType ?? '') === 'Connectée' ? 'selected' : ''; ?>>Connectée</option>
                    <option value="Classique" <?php echo ($searchType ?? '') === 'Classique' ? 'selected' : ''; ?>>Classique</option>
                    <option value="Sport" <?php echo ($searchType ?? '') === 'Sport' ? 'selected' : ''; ?>>Sport</option>
                    <option value="Luxe" <?php echo ($searchType ?? '') === 'Luxe' ? 'selected' : ''; ?>>Luxe</option>
                    <option value="Plongée" <?php echo ($searchType ?? '') === 'Plongée' ? 'selected' : ''; ?>>Plongée</option>
                </select>

                <input type="number" name="min_price" class="form-input" step="0.01"
                       placeholder="Prix min (TND)"
                       value="<?php echo htmlspecialchars($searchMin ?? ''); ?>">

                <input type="number" name="max_price" class="form-input" step="0.01"
                       placeholder="Prix max (TND)"
                       value="<?php echo htmlspecialchars($searchMax ?? ''); ?>">

                <button type="submit" class="search-btn"><i class="fa-solid fa-search"></i> Rechercher</button>
                <a href="index.php?page=products" class="reset-btn"><i class="fa-solid fa-times"></i> Réinitialiser</a>
            </form>
        </section>

        <?php if ($isSearching ?? false): ?>
        <div class="search-results-info">
            <i class="fa-solid fa-filter"></i>
            <?php echo count($products); ?> résultat(s) trouvé(s)
            <?php if (!empty($searchName)): ?> — Nom: "<?php echo htmlspecialchars($searchName); ?>"<?php endif; ?>
            <?php if (!empty($searchType)): ?> — Type: <?php echo htmlspecialchars($searchType); ?><?php endif; ?>
            <?php if (!empty($searchMin)): ?> — Prix min: <?php echo htmlspecialchars($searchMin); ?> TND<?php endif; ?>
            <?php if (!empty($searchMax)): ?> — Prix max: <?php echo htmlspecialchars($searchMax); ?> TND<?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Section catalogue complet -->
        <section class="catalogue" id="all-products">
            <h2>Toutes Nos Montres</h2>

            <div class="card-container">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                    <article class="card">
                        <?php
                        $imgSrc = $product->getImage();
                        // Vérifier si l'image est dans uploads/ ou à la racine
                        if ($imgSrc && file_exists(__DIR__ . '/../uploads/' . $imgSrc)) {
                            $imgSrc = 'uploads/' . $imgSrc;
                        }
                        ?>
                        <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($product->getName()); ?>">
                        <h4><?php echo htmlspecialchars($product->getName()); ?></h4>
                        <?php if ($product->getOldPrice() && $product->getOldPrice() > 0): ?>
                            <p style="text-decoration: line-through; color: gray; font-size: 0.9rem;"><?php echo number_format($product->getOldPrice(), 2); ?> TND</p>
                            <p style="color: red; font-weight: bold;"><?php echo number_format($product->getPrice(), 2); ?> TND</p>
                        <?php else: ?>
                            <p style="font-size: 20px; font-weight: bold;"><?php echo number_format($product->getPrice(), 2); ?> TND</p>
                        <?php endif; ?>

                        <?php if ($product->getIsOutOfStock()): ?>
                            <button class="btn-out" disabled>Rupture de Stock</button>
                        <?php else: ?>
                            <button class="btn-view" onclick="alert('✓ Produit ajouté au panier!')">Ajouter au Panier</button>
                        <?php endif; ?>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #A0ABC0; font-style: italic;">Aucun produit trouvé pour ces critères.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Section avantages -->
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

        <!-- Tableau de comparaison -->
        <section style="padding: 50px 20px; background-color: #f5f5f5;">
            <h2 style="text-align: center; margin-bottom: 40px; font-size: 32px; color: #333;">Comparez Nos Best-Sellers</h2>
            <table class="comparison-table">
                <caption>Tableau Comparatif des Modèles Populaires 2025</caption>
                <thead>
                    <tr>
                        <th>Modèle</th><th>Type</th><th>Étanchéité</th><th>Autonomie</th><th>Garantie</th><th>Prix (TND)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>ENZO BRO-BLACK</strong></td>
                        <td><span class="type-badge type-connectee">Connectée</span></td>
                        <td>5 ATM (50m)</td><td>3-5 jours</td><td>2 ans</td>
                        <td style="color: red; font-weight: bold;">260,100</td>
                    </tr>
                    <tr>
                        <td><strong>Daniel Wellington</strong></td>
                        <td><span class="type-badge type-classique">Classique</span></td>
                        <td>3 ATM (30m)</td><td>Pile 2 ans</td><td>2 ans</td>
                        <td style="font-weight: bold;">631,59</td>
                    </tr>
                    <tr>
                        <td><strong>Rolex Sea-Dweller</strong></td>
                        <td><span class="type-badge type-plongee">Plongée</span></td>
                        <td>100 ATM (1000m)</td><td>Automatique</td><td>5 ans</td>
                        <td style="font-weight: bold;">2663,52</td>
                    </tr>
                    <tr>
                        <td><strong>Casio G-Shock</strong></td>
                        <td><span class="type-badge type-sport">Sport</span></td>
                        <td>20 ATM (200m)</td><td>Pile 10 ans</td><td>1 an</td>
                        <td style="font-weight: bold;">450,00</td>
                    </tr>
                    <tr>
                        <td><strong>Apple Watch S9</strong></td>
                        <td><span class="type-badge type-connectee">Connectée</span></td>
                        <td>5 ATM (50m)</td><td>18 heures</td><td>1 an</td>
                        <td style="font-weight: bold;">1250,00</td>
                    </tr>
                    <tr>
                        <td><strong>TAG Heuer Carrera</strong></td>
                        <td><span class="type-badge type-classique">Classique</span></td>
                        <td>10 ATM (100m)</td><td>Automatique</td><td>2 ans</td>
                        <td style="font-weight: bold;">2100,00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <i class="fa-solid fa-info-circle" style="color: gold; margin-right: 8px;"></i>
                            Tous les prix incluent la TVA | Garantie constructeur | Livraison gratuite en Tunisie
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div style="text-align: center; margin-top: 25px; padding: 20px;">
                <p style="font-size: 16px; color: #666; margin-bottom: 15px;"><strong>Légende des types:</strong></p>
                <span class="type-badge type-connectee" style="margin: 5px;">Connectée</span>
                <span class="type-badge type-classique" style="margin: 5px;">Classique</span>
                <span class="type-badge type-plongee" style="margin: 5px;">Plongée</span>
                <span class="type-badge type-sport" style="margin: 5px;">Sport</span>
            </div>
        </section>

        <!-- Liens utiles -->
        <aside style="padding: 40px 20px; background-color: white; text-align: center;">
            <h3 style="margin-bottom: 20px; font-size: 24px; color: #333;">Liens Utiles</h3>
            <nav>
                <a href="#all-products" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-arrow-up"></i> Retour aux produits
                </a> |
                <a href="index.php?page=home" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-home"></i> Page d'accueil
                </a> |
                <a href="index.php?page=contact" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-envelope"></i> Nous contacter
                </a> |
                <a href="https://www.watchtime.com" target="_blank" rel="noopener" style="margin: 0 15px; color: #667eea; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-external-link"></i> Magazine WatchTime
                </a>
            </nav>
        </aside>

<?php require __DIR__ . '/layout/footer.php'; ?>
