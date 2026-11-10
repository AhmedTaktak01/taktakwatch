<?php
session_start();
require_once 'db.php';

// Check if user is logged in (Simple auth for admin: just check if session username exists)
// Ideally, we'd have an 'is_admin' column, but for simplicity, we just check login.
if (!isset($_SESSION['username'])) {
    die("Accès refusé. Veuillez vous <a href='login.html'>connecter</a>.");
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin_products.php");
    exit();
}

// Handle Add / Edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $type = $_POST['type'] ?? 'Classique';
    $img = $_POST['image'] ?? 'watch1.jpg'; // simplifying image upload to just string
    $stock = isset($_POST['is_out_of_stock']) ? 1 : 0;

    if ($id) {
        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, type=?, image=?, is_out_of_stock=? WHERE id=?");
        $stmt->bind_param("sdssii", $name, $price, $type, $img, $stock, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, price, type, image, is_out_of_stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $name, $price, $type, $img, $stock);
        $stmt->execute();
    }
    header("Location: admin_products.php");
    exit();
}

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
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

        /* Ambient background glow */
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

        .brand h1 {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: var(--gold);
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .brand p {
            font-size: 0.9rem;
            color: var(--text-sub);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-links a:hover { color: var(--gold); }

        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .panel-title {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 25px;
            font-style: italic;
        }

        /* Form Styling */
        .admin-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-sub);
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group select {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 12px 15px;
            font-family: var(--font-body);
            font-size: 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.1);
        }

        .checkbox-group {
            flex-direction: row;
            align-items: center;
            gap: 12px;
            margin-top: 15px;
        }

        .checkbox-group input[type="checkbox"] {
            accent-color: var(--gold);
            width: 18px;
            height: 18px;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .btn-gold {
            background: linear-gradient(135deg, #BF953F, #FCF6BA, #B38728, #FBF5B7);
            color: #000;
            border: none;
            padding: 12px 30px;
            font-family: var(--font-body);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.2);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-main);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 12px 30px;
            font-family: var(--font-body);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-ghost:hover {
            border-color: var(--text-main);
            background: rgba(255,255,255,0.05);
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        .luxury-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: left;
        }

        .luxury-table th {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            color: var(--gold);
            padding: 20px 15px;
            border-bottom: 1px solid var(--border-color);
            font-style: italic;
        }

        .luxury-table td {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            vertical-align: middle;
            transition: background 0.3s;
        }

        .luxury-table tbody tr {
            transition: transform 0.3s, background 0.3s;
        }

        .luxury-table tbody tr:hover {
            background: rgba(212, 175, 55, 0.03);
            transform: scale(1.005);
        }

        .luxury-table tbody tr:hover td {
            border-bottom-color: var(--border-color);
        }

        .img-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            padding: 2px;
        }

        .product-name {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            color: #fff;
        }

        .product-type {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-sub);
        }

        .price-tag {
            font-family: var(--font-body);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .status-badge.in-stock {
            background: rgba(46, 204, 113, 0.1);
            color: var(--success);
            border: 1px solid rgba(46, 204, 113, 0.2);
        }

        .status-badge.out-stock {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger);
            border: 1px solid rgba(231, 76, 60, 0.2);
        }

        .action-btns {
            display: flex;
            gap: 15px;
        }

        .action-btns a {
            color: var(--text-sub);
            text-decoration: none;
            transition: color 0.3s, transform 0.3s;
            font-size: 1.2rem;
        }

        .action-btns a.edit:hover { color: var(--gold); transform: translateY(-2px); }
        .action-btns a.delete:hover { color: var(--danger); transform: translateY(-2px); }

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
                <a href="index.html"><i class="fa-solid fa-home"></i> Accueil</a>
                <a href="admin_products.php" class="active"><i class="fa-solid fa-clock"></i> Produits</a>
                <a href="admin_contact.php"><i class="fa-solid fa-envelope"></i> Messages</a>
                <a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i> Déconnexion (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
            </div>
        </header>

        <?php
        $edit_mode = false;
        $edit_name = $edit_price = $edit_type = $edit_image = "";
        $edit_stock = 0;
        $edit_id = "";

        if (isset($_GET['edit'])) {
            $edit_mode = true;
            $edit_id = intval($_GET['edit']);
            $res = $conn->query("SELECT * FROM products WHERE id = $edit_id");
            if ($row = $res->fetch_assoc()) {
                $edit_name = $row['name'];
                $edit_price = $row['price'];
                $edit_type = $row['type'];
                $edit_image = $row['image'];
                $edit_stock = $row['is_out_of_stock'];
            }
        }
        ?>

        <section class="glass-panel">
            <h2 class="panel-title"><?php echo $edit_mode ? "Modifier la Pièce d'Horlogerie" : "Ajouter une Pièce à la Collection"; ?></h2>
            <form method="post" action="admin_products.php" class="admin-form">
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                
                <div class="form-group">
                    <label>Nom du Modèle</label>
                    <input type="text" name="name" required value="<?php echo htmlspecialchars($edit_name); ?>" placeholder="ex: Rolex Daytona">
                </div>
                
                <div class="form-group">
                    <label>Prix (TND)</label>
                    <input type="number" step="0.01" name="price" required value="<?php echo $edit_price; ?>" placeholder="0.00">
                </div>
                
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="type">
                        <option value="Connectée" <?php if($edit_type=='Connectée') echo 'selected';?>>Connectée</option>
                        <option value="Classique" <?php if($edit_type=='Classique') echo 'selected';?>>Classique</option>
                        <option value="Sport" <?php if($edit_type=='Sport') echo 'selected';?>>Sport</option>
                        <option value="Plongée" <?php if($edit_type=='Plongée') echo 'selected';?>>Plongée</option>
                        <option value="Luxe" <?php if($edit_type=='Luxe') echo 'selected';?>>Luxe (Haute Horlogerie)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fichier Image</label>
                    <input type="text" name="image" value="<?php echo htmlspecialchars($edit_image ? $edit_image : 'watch1.jpg'); ?>" placeholder="ex: watch1.jpg">
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" name="is_out_of_stock" id="stock" <?php echo $edit_stock ? 'checked' : ''; ?>>
                    <label for="stock" style="cursor:pointer">Marquer en rupture de stock</label>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-gold"><?php echo $edit_mode ? "Sauvegarder les Modifications" : "Intégrer à la Collection"; ?></button>
                    <?php if($edit_mode): ?> 
                        <a href="admin_products.php" class="btn-ghost">Annuler</a> 
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
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:20px;">
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="img" class="img-preview" onerror="this.src='Logo.png'">
                                    <div>
                                        <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                        <div class="product-type"><?php echo htmlspecialchars($row['type']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="price-tag"><?php echo number_format($row['price'], 2); ?> TND</td>
                            <td>
                                <?php if($row['is_out_of_stock']): ?>
                                    <span class="status-badge out-stock">Épuisé</span>
                                <?php else: ?>
                                    <span class="status-badge in-stock">En Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="admin_products.php?edit=<?php echo $row['id']; ?>" class="edit" title="Modifier"><i class="fa-solid fa-pen-nib"></i></a>
                                    <a href="admin_products.php?delete=<?php echo $row['id']; ?>" class="delete" title="Supprimer" onclick="return confirm('Retirer cette pièce de la collection ?');"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>
