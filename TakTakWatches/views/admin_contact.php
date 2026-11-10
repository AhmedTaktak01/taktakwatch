<?php
// ============================================
// Vue : Administration des Messages
// ============================================
// Variables injectées par ContactController : $contacts, $totalMessages
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakTak Exclusif - Messages Client</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/013baba51d.js" crossorigin="anonymous"></script>
    <style>
        :root {
            --bg-dark: #07090F;
            --panel-bg: rgba(15, 20, 35, 0.85);
            --gold: #D4AF37;
            --text-main: #E0E6ED;
            --text-sub: #A0ABC0;
            --border-color: rgba(212, 175, 55, 0.2);
            --danger: #E74C3C;
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Montserrat', sans-serif;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-body);
            background: radial-gradient(circle at 50% 0%, #1a2238 0%, var(--bg-dark) 100%);
            color: var(--text-main); min-height: 100vh; padding: 40px 20px; background-attachment: fixed;
        }
        body::before {
            content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: url('background.jpg') center/cover no-repeat; opacity: 0.1; z-index: -1; pointer-events: none;
        }
        .dashboard-wrapper { max-width: 1200px; margin: 0 auto; animation: fadeIn 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
        .brand h1 { font-family: var(--font-heading); font-size: 2.5rem; color: var(--gold); font-weight: 600; letter-spacing: 1px; margin-bottom: 5px; }
        .brand p { font-size: 0.9rem; color: var(--text-sub); letter-spacing: 2px; text-transform: uppercase; }
        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: var(--text-main); text-decoration: none; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s; display: flex; align-items: center; gap: 8px; }
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .glass-panel { background: var(--panel-bg); backdrop-filter: blur(16px); border: 1px solid var(--border-color); border-radius: 12px; padding: 30px; margin-bottom: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }
        .panel-title { font-family: var(--font-heading); font-size: 1.8rem; color: var(--gold); margin-bottom: 25px; font-style: italic; display: flex; align-items: center; justify-content: space-between; }
        .table-responsive { overflow-x: auto; }
        .luxury-table { width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; }
        .luxury-table th { font-family: var(--font-heading); font-size: 1.1rem; color: var(--gold); padding: 20px 15px; border-bottom: 1px solid var(--border-color); font-style: italic; }
        .luxury-table td { padding: 20px 15px; border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; transition: background 0.3s; }
        .luxury-table tbody tr { transition: transform 0.3s, background 0.3s; }
        .luxury-table tbody tr:hover { background: rgba(212, 175, 55, 0.03); transform: scale(1.005); }
        .msg-email { font-family: var(--font-heading); font-size: 1.1rem; color: #fff; }
        .msg-date { font-size: 0.8rem; color: var(--text-sub); letter-spacing: 1px; margin-top: 5px; }
        .msg-content { color: var(--text-main); line-height: 1.6; font-size: 0.95rem; max-width: 500px; }
        .action-btns { display: flex; gap: 15px; }
        .action-btns a { color: var(--text-sub); text-decoration: none; transition: color 0.3s, transform 0.3s; font-size: 1.2rem; }
        .action-btns a:hover { color: var(--danger); transform: translateY(-2px); }
        .empty-state { text-align: center; padding: 40px; color: var(--text-sub); font-style: italic; }
        .flash-msg { text-align: center; padding: 12px; font-size: 0.9rem; letter-spacing: 1px; border-radius: 8px; margin-bottom: 20px; }
        .flash-success { background: rgba(46,204,113,0.15); color: #2ECC71; border: 1px solid rgba(46,204,113,0.3); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <header>
            <div class="brand">
                <h1>TakTak Exclusif</h1>
                <p>Administration des Communications</p>
            </div>
            <div class="nav-links">
                <a href="index.php?page=home"><i class="fa-solid fa-home"></i> Accueil</a>
                <a href="index.php?page=admin_products"><i class="fa-solid fa-clock"></i> Produits</a>
                <a href="index.php?page=admin_contact" class="active"><i class="fa-solid fa-envelope"></i> Messages</a>
                <a href="index.php?page=logout"><i class="fa-solid fa-sign-out-alt"></i> Déconnexion (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
            </div>
        </header>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="flash-msg flash-success"><i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <section class="glass-panel">
            <h2 class="panel-title">
                Messages Clients
                <span style="font-size: 1rem; color: var(--text-sub); font-family: var(--font-body); font-style: normal;">
                    <?php echo $totalMessages; ?> message(s)
                </span>
            </h2>

            <div class="table-responsive">
                <?php if(!empty($contacts)): ?>
                <table class="luxury-table">
                    <thead>
                        <tr>
                            <th>Identité / Date</th>
                            <th>Message du Client</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td style="width: 250px;">
                                <div class="msg-email"><?php echo htmlspecialchars($c->getEmail()); ?></div>
                                <div class="msg-date"><?php echo date('d M Y - H:i', strtotime($c->getCreatedAt())); ?></div>
                            </td>
                            <td>
                                <div class="msg-content">
                                    <?php echo nl2br(htmlspecialchars($c->getMessage())); ?>
                                </div>
                            </td>
                            <td style="width: 80px; text-align: center;">
                                <div class="action-btns" style="justify-content: center;">
                                    <a href="index.php?page=delete_contact&id=<?php echo $c->getId(); ?>" class="delete" title="Supprimer ce message" onclick="return confirm('Retirer définitivement ce message des archives ?');"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fa-regular fa-envelope" style="font-size: 40px; color: var(--gold); margin-bottom: 15px; display: block;"></i>
                        Aucun message de la part de vos clients pour le moment.
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>
