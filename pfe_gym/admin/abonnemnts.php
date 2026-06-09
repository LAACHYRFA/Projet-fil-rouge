<?php
/**
 * Page de gestion des abonnements
 * Permet l'ajout, la modification et la suppression des formules
 */

session_start();
// Vérification de la session admin
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

class Abonnement {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    // Récupération de la liste des abonnements
    public function afficher() { 
        return $this->pdo->query("SELECT * FROM abonnement ORDER BY id_ab DESC")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Ajout d'une nouvelle formule
    public function ajouter($nom, $prix, $duree, $avantages) { 
        $stmt = $this->pdo->prepare("INSERT INTO abonnement (nom, prix_total, duree, description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $prix, $duree, $avantages]);
    }

    // Récupération d'un abonnement par ID
    public function getById($id) { 
        $stmt = $this->pdo->prepare("SELECT * FROM abonnement WHERE id_ab = ?"); 
        $stmt->execute([$id]); 
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Mise à jour d'une formule
    public function update($id, $nom, $prix, $duree, $avantages) { 
        $stmt = $this->pdo->prepare("UPDATE abonnement SET nom = ?, prix_total = ?, duree = ?, description = ? WHERE id_ab = ?");
        return $stmt->execute([$nom, $prix, $duree, $avantages, $id]); 
    }

    // Suppression d'une formule
    public function delete($id) { 
        $stmt = $this->pdo->prepare("DELETE FROM abonnement WHERE id_ab = ?"); 
        return $stmt->execute([$id]); 
    }
}

$abonnementObj = new Abonnement($pdo);

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] == "supprimer" && isset($_GET['id'])) { 
    $abonnementObj->delete(intval($_GET['id']));
    header("Location: abonnemnts.php"); exit(); 
}

$updateMode = false;
$editData = []; 

// Traitement du mode modification
if (isset($_GET['action']) && $_GET['action'] == "modifier" && isset($_GET['id'])) { 
    $updateMode = true;
    $editData = $abonnementObj->getById(intval($_GET['id']));
}

// Traitement de l'enregistrement (Ajout ou Modification)
if (isset($_POST['save_forfait'])) {
    $nom = $_POST['nom_forfait']; 
    $prix = $_POST['prix']; 
    $duree = $_POST['duree']; 
    $avantages = $_POST['avantages'];
    
    if (isset($_POST['forfait_id']) && !empty($_POST['forfait_id'])) { 
        $abonnementObj->update($_POST['forfait_id'], $nom, $prix, $duree, $avantages); 
    } else { 
        $abonnementObj->ajouter($nom, $prix, $duree, $avantages); 
    }
    header("Location: abonnemnts.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fitness Pro - Gestion Abonnements</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/forms_tables.css">
</head>
<body>
    
    <div class="sidebar">
        <div class="sidebar-logo">FITNESS PRO</div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="active"><a href="abonnemnts.php">Abonnements</a></li>
            <li><a href="equipements.php">Équipements</a></li>
            <li><a href="coachs.php">Coachs</a></li>
            <li><a href="users.php">Utilisateur</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <header><h2>Gestion des Abonnements</h2></header>
        <div class="content-container">
            
            <div class="form-section">
                <h3><?php echo $updateMode ? "Modifier la formule" : "Ajouter une nouvelle formule"; ?></h3>
                <form method="POST">
                    <?php if ($updateMode) { echo '<input type="hidden" name="forfait_id" value="'.$editData['id_ab'].'">'; } ?>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nom du Forfait</label>
                            <input type="text" name="nom_forfait" value="<?php echo $updateMode ? $editData['nom'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Prix (DH)</label>
                            <input type="number" name="prix" value="<?php echo $updateMode ? $editData['prix_total'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Durée</label>
                            <input type="text" name="duree" value="<?php echo $updateMode ? $editData['duree'] : ''; ?>" required>
                        </div>
                        <div class="form-group full-width">
                            <label>Avantages</label>
                            <textarea name="avantages"><?php echo $updateMode ? $editData['description'] : ''; ?></textarea>
                        </div>
                    </div>
                    <button type="submit" name="save_forfait" class="btn-submit">Enregistrer</button>
                    <?php if ($updateMode) { echo '<a href="abonnemnts.php" class="btn-cancel">Annuler</a>'; } ?>
                </form>
            </div>
            
            <div class="table-section">
                <h3>Formules Actuelles</h3>
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Nom</th><th>Prix</th><th>Durée</th><th>Avantages</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php
                        foreach ($abonnementObj->afficher() as $item) {
                            echo '<tr>
                                    <td>#'.$item['id_ab'].'</td>
                                    <td><strong>'.$item['nom'].'</strong></td>
                                    <td>'.$item['prix_total'].' DH</td>
                                    <td>'.$item['duree'].'</td>
                                    <td>'.$item['description'].'</td>
                                    <td>
                                        <a href="?action=modifier&id='.$item['id_ab'].'" class="btn-edit">Modifier</a>
                                        <a href="?action=supprimer&id='.$item['id_ab'].'" class="btn-supprimer">Supprimer</a>
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