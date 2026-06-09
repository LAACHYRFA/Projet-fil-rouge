<?php
// Démarrage de la session pour gérer l'authentification
session_start();
require "connexion.php";

// Vérification si le formulaire de connexion est soumis
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Recherche de l'utilisateur par son adresse email dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // 2. Vérification de l'existence de l'utilisateur et de la validité du mot de passe
    if($user && password_verify($password, $user['password'])){
        // Connexion réussie : enregistrement des informations dans la session
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['user_name'] = $user['nom_completed'];
        
        // Redirection vers la page de réservation
        header("Location: reservation.php"); 
        exit();
    } else {
        // Message d'erreur en cas d'identifiants incorrects
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Fitness Pro</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>

 <div class="container">
    <div class="custom-card">
        <h2>Connexion</h2>
        
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" class="input-field" required>
            </div>
            
            <button type="submit" name="login" class="btn-submit">Se connecter</button>
        </form>
        
        <p>Pas encore de compte ? <a href="signup.php">S'inscrire</a></p>
    </div>
</div>

</body>
</html>