/* ===================================
   GESTION DU CHANGEMENT D'IMAGE DES MONTRES
   =================================== */

// Attendre que le DOM soit complètement chargé avant d'exécuter le code
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner l'élément image de la montre
    const enzo = document.getElementById('enzo');
    
    // Vérifier si l'élément existe sur la page
    if (enzo) {
        // Sélectionner les boutons de couleur
        const goldButton = document.querySelector('.gold');
        const silverButton = document.querySelector('.silver');
        const blackButton = document.querySelector('.black');

        /* Fonction pour changer l'image en version argentée
         * Modifie la source de l'image pour afficher la montre argentée
         */
        function toSilver() {
            enzo.src = 'enzo-silver.jpg';
            // Animation de transition
            enzo.style.opacity = '0.5';
            setTimeout(() => {
                enzo.style.opacity = '1';
            }, 200);
        }

        /* Fonction pour changer l'image en version noire
         * Modifie la source de l'image pour afficher la montre noire
         */
        function toBlack() {
            enzo.src = 'enzo-black.jpg';
            // Animation de transition
            enzo.style.opacity = '0.5';
            setTimeout(() => {
                enzo.style.opacity = '1';
            }, 200);
        }

        /* Fonction pour changer l'image en version or
         * Modifie la source de l'image pour afficher la montre dorée
         */
        function toGold() {
            enzo.src = 'watch1.jpg';
            // Animation de transition
            enzo.style.opacity = '0.5';
            setTimeout(() => {
                enzo.style.opacity = '1';
            }, 200);
        }

        // Ajouter les écouteurs d'événements aux boutons
        // Déclenche le changement d'image au clic sur chaque bouton
        goldButton.addEventListener('click', toGold);
        silverButton.addEventListener('click', toSilver);
        blackButton.addEventListener('click', toBlack);
    }
});

/* ===================================
   FONCTION D'AJOUT AU PANIER
   =================================== */

/**
 * Fonction pour ajouter un produit au panier
 * Affiche une alerte de confirmation et pourrait être étendue
 * pour gérer un vrai panier d'achat
 */
function addToCart() {
    // Message de confirmation
    alert("✓ ENZO COLLECTION EC209 a été ajouté à votre panier!");
    
    // Optionnel: Animation du bouton après ajout
    const cartBtn = document.querySelector('.cart-button');
    if (cartBtn) {
        cartBtn.style.backgroundColor = 'darkgreen';
        setTimeout(() => {
            cartBtn.style.backgroundColor = 'green';
        }, 500);
    }
    
    // Dans une vraie application, on pourrait:
    // - Sauvegarder le produit dans localStorage
    // - Mettre à jour un compteur de panier
    // - Envoyer les données à un serveur
}

/* ===================================
   FONCTIONS DE VALIDATION DE FORMULAIRES
   =================================== */

/**
 * Fonction utilitaire pour vérifier si des champs sont vides
 * @param {Array} fields - Tableau de valeurs de champs à vérifier
 * @returns {boolean} - True si au moins un champ est vide
 */
function areFieldsEmpty(fields) {
    // Vérifie si au moins un champ est vide après suppression des espaces
    return fields.some(value => value.trim() === "");
}

/**
 * Fonction de validation du formulaire de contact
 * Vérifie que l'email et le message ne sont pas vides
 * @returns {boolean} - True si le formulaire est valide, False sinon
 */
function contact() {
    // Récupérer les valeurs des champs du formulaire
    const email = document.getElementById("username").value;
    const message = document.getElementById("Message").value;
    
    // Vérifier si les champs sont vides
    if (areFieldsEmpty([email, message])) {
        alert("⚠ Veuillez remplir tous les champs obligatoires.");
        return false; // Empêche la soumission du formulaire
    }
    
    // Validation supplémentaire de l'email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("⚠ Veuillez entrer une adresse email valide.");
        return false;
    }
    
    // Message de succès
    alert("✓ Votre message a été envoyé avec succès!");
    return true; // Permet la soumission du formulaire
}

/**
 * Fonction de validation du formulaire d'inscription
 * Vérifie que tous les champs sont remplis et valides
 * @returns {boolean} - True si le formulaire est valide, False sinon
 */
function signup() {
    // Récupérer les valeurs des champs du formulaire
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    
    // Vérifier si les champs sont vides
    if (areFieldsEmpty([username, email, password])) {
        alert("⚠ Tous les champs sont obligatoires.");
        return false; // Empêche la soumission du formulaire
    }
    
    // Validation du nom d'utilisateur (minimum 3 caractères)
    if (username.length < 3) {
        alert("⚠ Le nom d'utilisateur doit contenir au moins 3 caractères.");
        return false;
    }
    
    // Validation de l'email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("⚠ Veuillez entrer une adresse email valide.");
        return false;
    }
    
    // Validation du mot de passe (minimum 6 caractères)
    if (password.length < 6) {
        alert("⚠ Le mot de passe doit contenir au moins 6 caractères.");
        return false;
    }
    
    // Message de succès
    alert("✓ Inscription complétée avec succès!");
    return true; // Permet la soumission du formulaire
}

/**
 * Fonction de validation du formulaire de connexion
 * Vérifie que le nom d'utilisateur et le mot de passe ne sont pas vides
 * @returns {boolean} - True si le formulaire est valide, False sinon
 */
function login() {
    // Récupérer les valeurs des champs du formulaire
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    
    // Vérifier si les champs sont vides
    if (areFieldsEmpty([username, password])) {
        alert("⚠ Le nom d'utilisateur et le mot de passe ne peuvent pas être vides.");
        return false; // Empêche la soumission du formulaire
    }
    
    // Message de succès
    alert("✓ Connexion réussie!");
    return true; // Permet la soumission du formulaire
}

/* ===================================
   ANIMATION DE DÉFILEMENT FLUIDE
   =================================== */

/**
 * Améliore l'expérience de défilement vers les ancres
 * Cette fonction est appelée automatiquement grâce à scroll-behavior: smooth en CSS
 */
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner tous les liens qui pointent vers des ancres
    const smoothLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Récupérer la cible de l'ancre
            const targetId = this.getAttribute('href');
            
            // Ignorer les liens qui ne pointent que vers "#"
            if (targetId === '#') return;
            
            // Trouver l'élément cible
            const targetElement = document.querySelector(targetId);
            
            // Si l'élément existe, défiler vers lui
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

/* ===================================
   ANIMATION DES CARTES AU CHARGEMENT
   =================================== */

/**
 * Ajoute une animation d'apparition progressive aux cartes de produits
 * Améliore l'expérience utilisateur lors du chargement de la page
 */
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner toutes les cartes de produits
    const cards = document.querySelectorAll('.card');
    
    // Ajouter l'animation à chaque carte avec un délai progressif
    cards.forEach((card, index) => {
        // Définir un délai d'animation pour chaque carte
        card.style.animationDelay = `${index * 0.1}s`;
    });
});

/* ===================================
   GESTION DU MENU RESPONSIVE (OPTIONNEL)
   =================================== */

/**
 * Fonction pour gérer l'affichage du menu sur mobile
 * Peut être étendue pour ajouter un menu hamburger
 */
function toggleMenu() {
    const navLinks = document.querySelector('.navlinks');
    navLinks.classList.toggle('active');
}

/* ===================================
   VALIDATION EN TEMPS RÉEL DES FORMULAIRES
   =================================== */

/**
 * Ajoute une validation en temps réel pour améliorer l'UX
 * Affiche des messages d'erreur pendant que l'utilisateur tape
 */
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionner tous les champs de formulaire
    const formInputs = document.querySelectorAll('input, textarea');
    
    formInputs.forEach(input => {
        // Ajouter un écouteur d'événement pour la validation en temps réel
        input.addEventListener('blur', function() {
            // Vérifier si le champ est requis et vide
            if (this.hasAttribute('required') && this.value.trim() === '') {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = '';
            }
        });
    });
});