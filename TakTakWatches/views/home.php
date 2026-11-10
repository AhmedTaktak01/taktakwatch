<?php
// ============================================
// Vue : Page d'accueil
// ============================================
$pageTitle = "Taktak Watches - Accueil";
$extraStyles = '
    .highlight-text {
        background: linear-gradient(90deg, gold, silver);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        color: transparent;
        font-weight: bold;
        display: inline-block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card { animation: fadeIn 0.6s ease-in-out; }
';
require __DIR__ . '/layout/header.php';
?>

        <!-- Section Hero -->
        <section class="hero">
            <div class="hero-text">
                <h1>Le temps c'est de l'argent,<br>alors pourquoi ne pas le dépenser judicieusement?</h1>
                <h3>Découvrez notre <span class="highlight-text">collection exceptionnelle</span> de montres</h3>
                <div class="hero-btn">
                    <a href="index.php?page=products"><button>COMMANDER MAINTENANT</button></a>
                </div>
            </div>
        </section>

        <!-- Section Catalogue de produits -->
        <section class="catalogue" id="products">
            <h2>Notre Collection</h2>
            <div class="card-container">
                <article class="card">
                    <img src="watch1.jpg" alt="Montre ENZO BRO-BLACK">
                    <h4>ENZO BRO-BLACK</h4>
                    <p>260,100 TND<sup style="color: green;">-10%</sup></p>
                    <a href="enzo.html"><button class="btn-view">Voir Produit</button></a>
                </article>

                <article class="card">
                    <img src="watch2.png" alt="Montre Daniel Wellington">
                    <h4>Daniel Wellington</h4>
                    <p>631,59 TND</p>
                    <a href="index.php?page=products"><button class="btn-view">Voir Produit</button></a>
                </article>

                <article class="card">
                    <img src="watch3.png" alt="Montre Rolex Sea-Dweller">
                    <h4>Rolex Sea-Dweller</h4>
                    <p>2663,52 TND</p>
                    <a href="index.php?page=products"><button class="btn-view">Voir Produit</button></a>
                </article>
            </div>
            <div class="catalogue-btn">
                <a href="index.php?page=products"><button>VOIR TOUS LES PRODUITS</button></a>
            </div>
        </section>

        <!-- Section À propos -->
        <section class="about-us" id="about">
            <div class="about-container">
                <img src="LogoInverted.png" alt="Logo Taktak Watches">
                <article class="about-text">
                    <h2>À Propos de Nous</h2>
                    <p>
                        Chez <strong>Taktak Watches</strong>, nous croyons que le temps est précieux, tout comme votre
                        style. Notre mission est de fournir des montres de haute qualité qui allient élégance, fonctionnalité
                        et accessibilité. Avec un œil attentif sur l'artisanat et les détails, notre collection offre quelque chose pour
                        tout le monde.
                    </p>
                    <p>
                        Découvrez la précision et la sophistication comme jamais auparavant. Rejoignez notre communauté
                        de passionnés qui connaissent la valeur du temps.
                    </p>
                    <p><a href="#top" style="color: gold; text-decoration: none;">↑ Retour en haut</a></p>
                </article>
            </div>
        </section>

        <!-- Section Vidéo -->
        <section class="info-section">
            <div class="media-section">
                <video loop width="100%" autoplay muted>
                    <source src="Rolex.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo HTML5.
                </video>
            </div>
        </section>

<?php require __DIR__ . '/layout/footer.php'; ?>
