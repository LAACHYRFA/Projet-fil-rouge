<?php
// Connexion à la base de données
require "connexion.php";

// Initialisation des variables pour la recherche
$rechercher = "";
$sql = "SELECT * FROM coach";
$params = [];

// Vérification si le formulaire de recherche a été soumis
if(isset($_POST['ok'])){
    $rechercher = trim($_POST['rechercher']);
    if(!empty($rechercher)){
        // Préparation de la requête avec filtre LIKE pour la recherche par nom
        $sql = "SELECT * FROM coach WHERE nom_complet LIKE :name";
        $params = [":name" => "%$rechercher%"];
    }
}

// Exécution de la requête et récupération des résultats
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$coachs = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachs - Fitness Pro</title>
       <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/cards.css">
</head>
<body>

    <header class="main_header">
        <div class="header_logo">
            <img src="assets/images/page_acceuil/logo.png" class="logo_img" alt="Logo">
            <span>FITNESS PRO</span>
        </div>
        <ul class="nav_links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="coachs.php" class="active">Coachs</a></li>
            <li><a href="equipements.php">Équipements</a></li>
            <li><a href="abonnements.php">Abonnements</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>

    <div class="container">
        <h2 class="section-title" style="text-align: center; margin-bottom: 20px; text-transform: uppercase;">Nos <span style="color: #FF0000;">Coachs</span></h2>

        <div class="search-container">
            <form method="post" class="search-form">
                <input type="text" name="rechercher" class="input-field" placeholder="Rechercher un coach" value="<?= htmlspecialchars($rechercher) ?>">
                <button type="submit" name="ok" class="btn-submit">Rechercher</button>
            </form>
        </div>
        
        <div class="cards-grid">
            <?php if(!empty($coachs)) { 
                foreach($coachs as $coach){ ?>
                    <div class="custom-card">
                        <img src="<?= htmlspecialchars($coach['image']) ?>" alt="<?= htmlspecialchars($coach['nom_complet']) ?>">
                        <h3><?= htmlspecialchars($coach['nom_complet']) ?></h3>
                        <p class="card-spec"><?= htmlspecialchars($coach['specialite']) ?></p>
                        <p style="color: #aaa; font-size: 14px;">📧 <?= htmlspecialchars($coach['email']) ?></p>
                        <p style="color: #aaa; font-size: 14px;">📞 <?= htmlspecialchars($coach['telephone']) ?></p>
                    </div>
                <?php } 
            } else { 
                // Message en cas de résultat vide
                echo "<p style='text-align:center; grid-column: 1/-1; color: #aaa;'>Aucun coach trouvé</p>";
            } ?>
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

</body>
</html>