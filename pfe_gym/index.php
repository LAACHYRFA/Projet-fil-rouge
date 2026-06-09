<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Pro - Accueil</title>
       <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/cards.css">
</head>
<body>

    <header class="main_header">
        <div class="header_logo">
            <img src="assets/images/page_acceuil/logo.png" alt="Logo Fitness Pro" class="logo_img">
            <span>FITNESS PRO</span>
        </div>
        <nav class="header_nav">
            <ul class="nav_links">
                <li><a href="index.php" class="active">Accueil</a></li>
                <li><a href="abonnements.php">Abonnement</a></li>
                <li><a href="coachs.php">Coachs</a></li>
                <li><a href="equipements.php">Equipement</a></li>             
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero_section" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/images/page_acceuil/acceuil_bground.jpg'); height: 85vh; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center;">   
        <div class="hero_content">
            <h1 class="hero_title" style="font-size: 48px; font-weight: 900; letter-spacing: 2px; color: #fff; margin-bottom: 20px;">TRANSFORMEZ VOTRE CORPS</h1>
            <p class="subtitle" style="font-size: 18px; color: #ccc; max-width: 600px; margin: auto;">Atteignez vos objectifs fitness avec nos coachs experts et nos programmes personnalisés.</p>
        </div>
    </section>

    <div class="container">
        <h2 class="section-title" style="text-align: center; font-size: 30px; margin-bottom: 40px; text-transform: uppercase;">Choisissez votre <span>forfait</span></h2>
        
        <div class="pricing-grid">
            <div class="custom-card">
                <h3 style="color: #FF0000; font-size: 22px;">DÉCOUVERTE</h3>
                <div class="card-price">29€<span style="font-size: 14px; font-weight: normal; color: #aaa;">/mois</span></div>
                <ul style="list-style: none; margin: 15px 0; padding: 0; color: #ccc; display: flex; flex-direction: column; gap: 8px;">
                    <li>✓ Coaching en ligne</li>
                    <li>✓ Cours collectifs</li>
                    <li>✓ Accès à l'application</li>
                </ul>
                <a href="reservation.php" class="btn-submit">Réserver</a>
            </div>

            <div class="custom-card" style="border-color: #FF0000; position: relative;">
                <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #FF0000; color: #fff; padding: 4px 12px; font-size: 11px; font-weight: bold; border-radius: 20px;">POPULAIRE</span>
                <h3 style="color: #FF0000; font-size: 22px; margin-top: 5px;">PREMIUM</h3>
                <div class="card-price">49€<span style="font-size: 14px; font-weight: normal; color: #aaa;">/mois</span></div>
                <ul style="list-style: none; margin: 15px 0; padding: 0; color: #ccc; display: flex; flex-direction: column; gap: 8px;">
                    <li>✓ Coach dédié</li>
                    <li>✓ Plan nutritionnel</li>
                    <li>✓ 3 séances/semaine</li>
                    <li>✓ Suivi personnalisé</li>
                </ul>
                <a href="reservation.php" class="btn-submit">Réserver</a>
            </div>

            <div class="custom-card">
                <h3 style="color: #FF0000; font-size: 22px;">ÉLITE</h3>
                <div class="card-price">79€<span style="font-size: 14px; font-weight: normal; color: #aaa;">/mois</span></div>          
                <ul style="list-style: none; margin: 15px 0; padding: 0; color: #ccc; display: flex; flex-direction: column; gap: 8px;">
                    <li>✓ Tout Premium</li>
                    <li>✓ Séances quotidiennes</li>
                    <li>✓ Accès illimité</li>
                </ul>
                <a href="reservation.php" class="btn-submit">Réserver</a>
            </div>
        </div>
    </div>
 
    <div class="container">
        <h2 class="section-title" style="text-align: center; font-size: 30px; margin-bottom: 40px; text-transform: uppercase;">Nos <span>coachs</span></h2>
        <div class="cards-grid">
            <div class="custom-card">
                <img src="assets/images/page_acceuil/coach_lina.jpg" alt="Lina El Idrissi">
                <h3>Lina El Idrissi</h3>
                <p class="card-spec">Fitness & Musculation</p>
            </div>
            <div class="custom-card">
                <img src="assets/images/page_acceuil/ouss_bouk.png" alt="Oussama Boukh">
                <h3>Oussama Boukh</h3>
                <p class="card-spec">Fitness & Musculation</p>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="section-title" style="text-align: center; font-size: 30px; margin-bottom: 40px; text-transform: uppercase;">NOS <span>ÉQUIPEMENTS</span></h2>
        <div class="cards-grid">
            <div class="custom-card">
                <img src="assets/images/page_acceuil/cardio.webp" alt="Machine cardio">
                <h3>Machine cardio</h3>
            </div>
            <div class="custom-card">
                <img src="assets/images/page_acceuil/kettlebels.avif" alt="Kettlebells">
                <h3>Kettlebells</h3>
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="assets/images/page_acceuil/logo.png" alt="Logo Fitness Pro" class="logo_img" style="width:40px; margin-right:10px;">
                    <span>FITNESS PRO</span>
                </div>
                <p class="footer-text">Transformez votre corps et restez en bonne santé avec nous.</p>
            </div>
            <div class="footer-contact">
                <h3 class="contact-title">NOUS CONTACTER</h3>
                <ul class="contact-list" style="list-style:none; padding:0; margin:0;">
                    <li>Tanger, Maroc</li>
                    <li>+212-612345678</li>
                    <li>gym@email.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Fitness Pro – Tous droits réservés.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>