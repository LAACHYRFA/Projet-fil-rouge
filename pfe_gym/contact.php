<?php
require "connexion.php";

$success_msg = "";
$error_msg = "";

if (isset($_POST['ok'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($nom) && !empty($email) && !empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO contact (nom, email, message, date_envoi) VALUES (:nom, :email, :message, NOW())");
        $stmt->execute([':nom' => $nom, ':email' => $email, ':message' => $message]);
        $success_msg = "Votre message a été envoyé avec succès !";
    } else {
        $error_msg = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Pro - Contact</title>
      <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/search.css">
    <link rel="stylesheet" href="assets/css/cards.css">
    <link rel="stylesheet" href="assets/css/contact.css">
</head>
<body>

    <header class="main_header">
        <div class="header_logo">
            <img src="assets/images/page_acceuil/logo.png" alt="Logo Fitness Pro" class="logo_img">
            <span>FITNESS PRO</span>
        </div>
        <ul class="nav_links">
            <li><a href="index.php">Accueil</a></li>
            <li><a href="coachs.php">Coachs</a></li>
            <li><a href="equipements.php">Équipements</a></li>
            <li><a href="abonnements.php">Abonnements</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
        </ul>
    </header>

    <div class="container">
        <h2 class="section-title">Contactez-<span>nous</span></h2>

        <?php if (!empty($success_msg)): ?>
            <p class="alert-success"><?= $success_msg ?></p>
        <?php endif; ?>
        <?php if (!empty($error_msg)): ?>
            <p class="alert-error"><?= $error_msg ?></p>
        <?php endif; ?>

        <div class="contact-wrapper">
            <form method="post" class="contact-form">
                <h3>Envoyez-nous un message</h3>
                <div class="form-group">
                    <label>Nom complet</label>
                    <input type="text" name="nom" class="input-field" placeholder="Votre nom" required>
                </div>
                <div class="form-group">
                    <label>Adresse e-mail</label>
                    <input type="email" name="email" class="input-field" placeholder="Votre email" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="5" placeholder="Écrivez votre message..." required></textarea>
                </div>
                <button type="submit" name="ok" class="btn-submit">Envoyer le message</button>
            </form>
        </div>
    </div>

    <footer class="main-footer">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="assets/images/page_acceuil/logo.png" class="logo_img" alt="Logo">
                    <span>FITNESS PRO</span>
                </div>
                <p class="footer-text">Transformez votre corps et restez en bonne santé avec nous.</p>
            </div>
            <div class="footer-contact">
                <h3 class="contact-title">NOUS CONTACTER</h3>
                <ul class="contact-list">
                    <li>Tanger, Maroc</li>
                    <li>+212-681116258</li> 
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