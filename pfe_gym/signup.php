<?php
// Démarrage de la session pour la gestion des données utilisateur
session_start();
require "connexion.php";

$error = "";

// Récupération de l'ID de l'abonnement depuis l'URL (si présent)
$id_abonnement = isset($_GET['id_ab']) ? intval($_GET['id_ab']) : null;

// Si un abonnement est sélectionné, on le stocke dans la session
if ($id_abonnement) {
    $_SESSION['id_abonnement'] = $id_abonnement;
}

// Traitement du formulaire d'inscription
if(isset($_POST['ok'])){
    $nom_completed = trim($_POST['nom_completed']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $telephone = trim($_POST['telephone']);
    $date_inscription = date('Y-m-d H:i:s');

    // Vérification que tous les champs sont remplis
    if(empty($nom_completed) || empty($email) || empty($password) || empty($telephone)){
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Vérification si l'utilisateur existe déjà
        $check = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $check->execute([$email]);

        if($check->rowCount() > 0){
            $error = "Cet email est déjà utilisé.";
        } else {
            // Insertion du nouvel utilisateur dans la base de données
            $sql = "INSERT INTO utilisateur (nom_completed, email, password, telephone, date_inscription) VALUES(?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                $nom_completed,
                $email,
                password_hash($password, PASSWORD_DEFAULT), // Hashage du mot de passe pour la sécurité
                $telephone,
                $date_inscription
            ]);

            if($result){
                $id_utilisateur = $pdo->lastInsertId();
                
                // Si un abonnement était choisi, on l'inscrit dans la table 'inscription'
                if(isset($_SESSION['id_abonnement'])) {
                    $sql_res = "INSERT INTO inscription (id_utilisateur, id_ab, date_inscription) VALUES (?, ?, ?)";
                    $pdo->prepare($sql_res)->execute([$id_utilisateur, $_SESSION['id_abonnement'], $date_inscription]);
                    unset($_SESSION['id_abonnement']); // Nettoyage de la session
                }
                
                // Redirection vers la page de connexion
                header("Location: login.php?msg=success");
                exit();
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Fitness Pro</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>

<div class="container">
    <div class="custom-card">
        <h2>Créer un compte</h2>

        <?php if(!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" name="nom_completed" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" class="input-field" required>
            </div>

            <button type="submit" name="ok" class="btn-submit">S'inscrire</button>
        </form>
        
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
    </div>
</div>

</body>
</html>