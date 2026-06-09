<?php
// Connexion à la base de données
require "connexion.php";

/**
 * Classe pour gérer les équipements
 */
class EquipementManager {
    private $pdo;

    public function __construct($dbConnection) {
        $this->pdo = $dbConnection;
    }

    // Fonction pour récupérer les équipements (avec ou sans recherche)
    public function getEquipements($searchQuery = "") {
        if (!empty($searchQuery)) {
            // Requête préparée pour la sécurité (recherche par nom)
            $sql = "SELECT * FROM equipement WHERE nom LIKE :name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':name' => "%$searchQuery%"]);
        } else {
            // Requête simple pour afficher tout le matériel
            $sql = "SELECT * FROM equipement";
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Initialisation du gestionnaire et récupération des données
$equipementManager = new EquipementManager($pdo);
$rechercher = isset($_POST['ok']) ? trim($_POST['rechercher']) : "";
$equipements = $equipementManager->getEquipements($rechercher);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Équipements - Fitness Pro</title>
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
            <li><a href="coachs.php">Coachs</a></li>
            <li><a href="equipements.php" class="active">Équipements</a></li>
            <li><a href="abonnements.php">Abonnements</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>

    <div class="container">
        <h2 class="section-title">Notre <span>Matériel</span></h2>

        <div class="search-container">
            <form method="POST" action="equipements.php" class="search-form">
                <input type="text" name="rechercher" class="input-field" placeholder="Rechercher par nom..." value="<?= htmlspecialchars($rechercher) ?>">
                <button type="submit" name="ok" class="btn-submit">Rechercher</button>
            </form>
        </div>

        <div class="cards-grid">
            <?php 
            if (!empty($equipements)) { 
                foreach ($equipements as $equipement) { ?>
                    <div class="custom-card">
                        <?php if (!empty($equipement['image'])): ?>
                            <img src="./<?= htmlspecialchars($equipement['image']) ?>" alt="Equipement">
                        <?php endif; ?>
                        <h3><?= htmlspecialchars($equipement['nom']) ?></h3>
                        <p style="color: #aaa; font-size:14px;">Catégorie: <?= htmlspecialchars($equipement['categorie']) ?></p>
                        <div class="card-price" style="font-size:16px;">Quantité: <?= htmlspecialchars($equipement['quantite']) ?></div>
                    </div>
                <?php } 
            } else { 
                // Message si aucun résultat n'est trouvé
                echo "<p style='text-align:center; grid-column: 1/-1; color: #aaa;'>Aucun équipement trouvé.</p>";
            } ?>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="assets/images/page_acceuil/logo.png" alt="Logo Fitness Pro" class="logo_img">
                    <span>FITNESS PRO</span>
                </div>
                <p class="footer-text">Transformez votre corps et restez en bonne santé avec nous.</p>
            </div>
            <div class="footer-contact">
                <h3 class="contact-title">NOUS CONTACTER</h3>
                <ul class="contact-list">
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