<?php
// ============================================
// Vue : Administration des Produits
// ============================================
// Variables injectées par ProductController : $products, $editProduct
// Gère le CRUD avec upload d'images via $_FILES
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakTak Exclusif - Gestion des Produits</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/013baba51d.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --bg-dark: #07090F;
            --panel-bg: rgba(15, 20, 35, 0.85);
            --gold: #D4AF37;
            --gold-hover: #F3E5AB;
            --text-main: #E0E6ED;
            --text-sub: #A0ABC0;
            --border-color: rgba(212, 175, 55, 0.2);
            --danger: #E74C3C;
            --success: #2ECC71;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Montserrat', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-body);
            background: radial-gradient(circle at 50% 0%, #1a2238 0%, var(--bg-dark) 100%);
            color: var(--text-main);
            min-height: 100vh;
            padding: 40px 20px;
            background-attachment: fixed;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('background.jpg') center/cover no-repeat;
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        .dashboard-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand h1 { font-family: var(--font-heading); font-size: 2.5rem; color: var(--gold); font-weight: 600; letter-spacing: 1px; margin-bottom: 5px; }
        .brand p { font-size: 0.9rem; color: var(--text-sub); letter-spacing: 2px; text-transform: uppercase; }

        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: var(--text-main); text-decoration: none; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s; display: flex; align-items: center; gap: 8px; }
        .nav-links a:hover { color: var(--gold); }

        .glass-panel { background: var(--panel-bg); backdrop-filter: blur(16px); border: 1px solid var(--border-color); border-radius: 12px; padding: 30px; margin-bottom: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .panel-title { font-family: var(--font-heading); font-size: 1.8rem; color: var(--gold); margin-bottom: 25px; font-style: italic; }

        .admin-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--text-sub); }
        .form-group input[type="text"], .form-group input[type="number"], .form-group select, .form-group textarea {
            background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255,255,255,0.1); color: white;
            padding: 12px 15px; font-family: var(--font-body); font-size: 1rem; border-radius: 4px; transition: all 0.3s ease;
        }
        .form-group input[type="file"] {
            background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255,255,255,0.1); color: white;
            padding: 10px; font-family: var(--font-body); font-size: 0.9rem; border-radius: 4px;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: var(--gold); box-shadow: 0 0 10px rgba(212, 175, 55, 0.1); }

        .checkbox-group { flex-direction: row; align-items: center; gap: 12px; margin-top: 15px; }
        .checkbox-group input[type="checkbox"] { accent-color: var(--gold); width: 18px; height: 18px; }
        .form-actions { grid-column: 1 / -1; display: flex; gap: 15px; margin-top: 10px; }

        .btn-gold {
            background: linear-gradient(135deg, #BF953F, #FCF6BA, #B38728, #FBF5B7);
            color: #000; border: none; padding: 12px 30px; font-family: var(--font-body);
            font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem;
            border-radius: 4px; cursor: pointer; transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2); }

        .btn-ghost {
            background: transparent; color: var(--text-main); border: 1px solid rgba(255,255,255,0.2);
            padding: 12px 30px; font-family: var(--font-body); font-weight: 500; text-transform: uppercase;
            letter-spacing: 2px; font-size: 0.9rem; border-radius: 4px; cursor: pointer; text-decoration: none;
            transition: all 0.3s; display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-ghost:hover { border-color: var(--text-main); background: rgba(255,255,255,0.05); }

        .table-responsive { overflow-x: auto; }
        .luxury-table { width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; }
        .luxury-table th { font-family: var(--font-heading); font-size: 1.1rem; color: var(--gold); padding: 20px 15px; border-bottom: 1px solid var(--border-color); font-style: italic; }
        .luxury-table td { padding: 20px 15px; border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; transition: background 0.3s; }
        .luxury-table tbody tr { transition: transform 0.3s, background 0.3s; }
        .luxury-table tbody tr:hover { background: rgba(212, 175, 55, 0.03); transform: scale(1.005); }
        .luxury-table tbody tr:hover td { border-bottom-color: var(--border-color); }

        .img-preview { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; border: 2px solid var(--border-color); padding: 2px; }
        .product-name { font-family: var(--font-heading); font-size: 1.2rem; color: #fff; }
        .product-type { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-sub); }
        .price-tag { font-family: var(--font-body); font-weight: 600; letter-spacing: 1px; }

        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .status-badge.in-stock { background: rgba(46, 204, 113, 0.1); color: var(--success); border: 1px solid rgba(46, 204, 113, 0.2); }
        .status-badge.out-stock { background: rgba(231, 76, 60, 0.1); color: var(--danger); border: 1px solid rgba(231, 76, 60, 0.2); }

        .action-btns { display: flex; gap: 15px; }
        .action-btns a { color: var(--text-sub); text-decoration: none; transition: color 0.3s, transform 0.3s; font-size: 1.2rem; }
        .action-btns a.edit:hover { color: var(--gold); transform: translateY(-2px); }
        .action-btns a.delete:hover { color: var(--danger); transform: translateY(-2px); }

        .flash-msg { text-align: center; padding: 12px; font-size: 0.9rem; letter-spacing: 1px; border-radius: 8px; margin-bottom: 20px; }
        .flash-success { background: rgba(46,204,113,0.15); color: var(--success); border: 1px solid rgba(46,204,113,0.3); }
        .flash-error { background: rgba(231,76,60,0.15); color: var(--danger); border: 1px solid rgba(231,76,60,0.3); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <header>
            <div class="brand">
                <h1>TakTak Exclusif</h1>
                <p>Administration des Collections</p>
            </div>
            <div class="nav-links">
                <a href="index.php?page=home"><i class="fa-solid fa-home"></i> Accueil</a>
                <a href="index.php?page=admin_products" class="active"><i class="fa-solid fa-clock"></i> Produits</a>
                <a href="index.php?page=admin_contact"><i class="fa-solid fa-envelope"></i> Messages</a>
                <a href="index.php?page=logout"><i class="fa-solid fa-sign-out-alt"></i> Déconnexion (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
            </div>
        </header>

        <!-- Messages flash -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="flash-msg flash-success"><i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="flash-msg flash-error"><i class="fa-solid fa-exclamation-circle"></i> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <section class="glass-panel">
            <h2 class="panel-title"><?php echo $editProduct ? "Modifier la Pièce d'Horlogerie" : "Ajouter une Pièce à la Collection"; ?></h2>
            <!-- enctype="multipart/form-data" pour l'upload de fichiers via $_FILES -->
            <form method="post" action="index.php?page=save_product" class="admin-form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $editProduct ? $editProduct->getId() : ''; ?>">
                <input type="hidden" name="current_image" value="<?php echo $editProduct ? htmlspecialchars($editProduct->getImage()) : 'watch1.jpg'; ?>">

                <div class="form-group">
                    <label>Nom du Modèle</label>
                    <input type="text" name="name" required value="<?php echo $editProduct ? htmlspecialchars($editProduct->getName()) : ''; ?>" placeholder="ex: Rolex Daytona">
                </div>

                <div class="form-group">
                    <label>Prix (TND)</label>
                    <input type="number" step="0.01" name="price" required value="<?php echo $editProduct ? $editProduct->getPrice() : ''; ?>" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="type">
                        <option value="Connectée" <?php if($editProduct && $editProduct->getType()=='Connectée') echo 'selected';?>>Connectée</option>
                        <option value="Classique" <?php if($editProduct && $editProduct->getType()=='Classique') echo 'selected';?>>Classique</option>
                        <option value="Sport" <?php if($editProduct && $editProduct->getType()=='Sport') echo 'selected';?>>Sport</option>
                        <option value="Plongée" <?php if($editProduct && $editProduct->getType()=='Plongée') echo 'selected';?>>Plongée</option>
                        <option value="Luxe" <?php if($editProduct && $editProduct->getType()=='Luxe') echo 'selected';?>>Luxe (Haute Horlogerie)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Description du produit..."><?php echo $editProduct ? htmlspecialchars($editProduct->getDescription()) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Image (<?php echo implode(', ', ALLOWED_EXTENSIONS); ?>)</label>
                    <input type="file" name="image_file" accept="image/*">
                    <?php if ($editProduct && $editProduct->getImage()): ?>
                        <small style="color: var(--text-sub);">Image actuelle : <?php echo htmlspecialchars($editProduct->getImage()); ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="is_out_of_stock" id="stock" <?php echo ($editProduct && $editProduct->getIsOutOfStock()) ? 'checked' : ''; ?>>
                    <label for="stock" style="cursor:pointer">Marquer en rupture de stock</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-gold"><?php echo $editProduct ? "Sauvegarder les Modifications" : "Intégrer à la Collection"; ?></button>
                    <?php if($editProduct): ?>
                        <a href="index.php?page=admin_products" class="btn-ghost">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <section class="glass-panel">
            <h2 class="panel-title">Inventaire de la Collection</h2>
            <div class="table-responsive">
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Modèle & Collection</th>
                            <th>Prix</th>
                            <th>Disponibilité</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <?php
                        $pImg = $p->getImage();
                        if ($pImg && file_exists(__DIR__ . '/../uploads/' . $pImg)) {
                            $pImg = 'uploads/' . $pImg;
                        }
                        ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:20px;">
                                    <img src="<?php echo htmlspecialchars($pImg); ?>" alt="img" class="img-preview" onerror="this.src='Logo.png'">
                                    <div>
                                        <div class="product-name"><?php echo htmlspecialchars($p->getName()); ?></div>
                                        <div class="product-type"><?php echo htmlspecialchars($p->getType()); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="price-tag"><?php echo number_format($p->getPrice(), 2); ?> TND</td>
                            <td>
                                <?php if($p->getIsOutOfStock()): ?>
                                    <span class="status-badge out-stock">Épuisé</span>
                                <?php else: ?>
                                    <span class="status-badge in-stock">En Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?page=admin_products&edit=<?php echo $p->getId(); ?>" class="edit" title="Modifier"><i class="fa-solid fa-pen-nib"></i></a>
                                    <a href="index.php?page=delete_product&id=<?php echo $p->getId(); ?>" class="delete" title="Supprimer" onclick="return confirm('Retirer cette pièce de la collection ?');"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
