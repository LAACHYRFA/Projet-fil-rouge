/**
 * ==========================================================================
 * FITNESS PRO - SCRIPT GLOBAL CLIENT
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", function () {
    
    // --- 1. Validation du formulaire de contact ---
    const contactForm = document.getElementById("contactForm");
    if (contactForm) {
        contactForm.addEventListener("submit", function (e) {
            let isValid = true;
            const fieldsToValidate = this.querySelectorAll("#nom, #email, #message");
            const errorDiv = document.getElementById("errorDisplay");
            const emailField = document.getElementById("email");
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Réinitialisation visuelle
            fieldsToValidate.forEach(input => {
                if(input) input.classList.remove("input-error");
            });
            if (errorDiv) errorDiv.innerText = "";

            // Vérification des champs vides
            fieldsToValidate.forEach(input => {
                if (input && input.value.trim() === "") {
                    e.preventDefault();
                    input.classList.add("input-error");
                    isValid = false;
                }
            });

            if (!isValid) {
                if (errorDiv) errorDiv.innerText = "⚠️ Attention : Veuillez remplir tous les champs obligatoires.";
                return;
            }

            // Validation de l'email via RegEx
            if (emailField && !emailPattern.test(emailField.value.trim())) {
                e.preventDefault();
                emailField.classList.add("input-error");
                if (errorDiv) errorDiv.innerText = "⚠️ Format invalide : Veuillez entrer une adresse email correcte.";
            }
        });
    }

    // --- 2. Validation des recherches (Coachs / Équipements) ---
    const searchForm = document.getElementById("searchForm");
    if (searchForm) {
        searchForm.addEventListener("submit", function (event) {
            const searchInput = document.getElementById("searchInput");
            const errorDiv = document.getElementById("errorDiv");
            
            if (searchInput && searchInput.value.trim() === "") {
                event.preventDefault(); 
                searchInput.classList.add("input-error");
                if (errorDiv) {
                    errorDiv.textContent = "Veuillez saisir un terme avant de lancer la recherche.";
                }
                searchInput.focus();
            }
        });

        const searchInput = document.getElementById("searchInput");
        if (searchInput) {
            searchInput.addEventListener("input", function () {
                this.classList.remove("input-error");
                const errorDiv = document.getElementById("errorDiv");
                if (errorDiv) errorDiv.textContent = "";
            });
        }
    }

    // --- 3. Animation dynamic d'apparition au Scroll ---
    const revealCards = document.querySelectorAll(".reveal-card");
    if (revealCards.length > 0) {
        function handleScrollReveal() {
            const windowHeight = window.innerHeight;
            revealCards.forEach(card => {
                const elementTop = card.getBoundingClientRect().top;
                const elementVisible = 100;

                if (elementTop < windowHeight - elementVisible) {
                    card.classList.add("reveal-active");
                }
            });
        }
        window.addEventListener("scroll", handleScrollReveal);
        handleScrollReveal();
    }
});

    
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.15 
        });

        const revealElements = document.querySelectorAll('.reveal');
        revealElements.forEach((el) => observer.observe(el));
    