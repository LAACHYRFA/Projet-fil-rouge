<?php
/**
 * Page de gestion des utilisateurs
 * Affichage simple et suppression directe
 */

session_start();
// Vérification de la session admin
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

class User {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    // Récupération de la liste des utilisateurs
    public function afficher() { 
        return $this->pdo->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Ajout d'un nouvel utilisateur
    public function ajouter($nom, $email, $password, $tel, $date) { 
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom_completed, email, password, telephone, date_inscription) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $email, $password, $tel, $date]); 
    }

    // Suppression directe d'un utilisateur
    public function delete($id) { 
        $stmt = $this->pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?"); 
        return $stmt->execute([$id]); 
    }
}

$userObj = new User($pdo);

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] == "supprimer" && isset($_GET['id'])) { 
    $userObj->delete(intval($_GET['id']));
    header("Location: users.php"); exit(); 
}

// Traitement de l'ajout
if (isset($_POST['ajouter'])) {
    $userObj->ajouter($_POST['nom_complet'], $_POST['email'], $_POST['password'], $_POST['telephone'], $_POST['date_inscription']);
    header("Location: users.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/forms_tables.css">
</head>
<body>
   
    <div class="sidebar">
        <div class="sidebar-logo">FITNESS PRO</div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="abonnemnts.php">Abonnements</a></li>
            <li><a href="equipements.php">Équipements</a></li>
            <li><a href="coachs.php">Coachs</a></li>
            <li class="active"><a href="users.php">Utilisateur</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header><h2>Gestion des utilisateurs</h2></header>
        <div class="content-container">
            
            <div class="form-section">
                <h3>Ajouter un utilisateur</h3>
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group"><label>Nom complet</label><input type="text" name="nom_complet" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                        <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
                        <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" required></div>
                        <div class="form-group"><label>Date d'inscription</label><input type="date" name="date_inscription" required></div>
                    </div>
                    <button type="submit" name="ajouter" class="btn-submit">Enregistrer</button>
                </form>
            </div>

            <div class="table-section">
                <h3>Liste des utilisateurs</h3>
                <table>
                    <thead>
                        <tr><th>ID</th><th>Nom complet</th><th>Email</th><th>Téléphone</th><th>Date</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        // Affichage des données sans traitement supplémentaire
                        foreach($userObj->afficher() as $u) {
                            echo '<tr>
                                    <td>#'.$u['id_utilisateur'].'</td>
                                    <td>'.$u['nom_completed'].'</td>
                                    <td>'.$u['email'].'</td>
                                    <td>'.$u['telephone'].'</td>
                                    <td>'.$u['date_inscription'].'</td>
                                    <td>
                                        <a href="?action=supprimer&id='.$u['id_utilisateur'].'" class="btn-supprimer">Supprimer</a>
                                    </td>
                                  </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>