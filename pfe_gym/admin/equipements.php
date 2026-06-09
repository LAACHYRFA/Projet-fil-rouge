<?php
/**
 * Page de gestion des équipements
 * Permet l'ajout, la modification et la suppression du matériel
 */

session_start();
// Vérification de la session admin
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

// Classe pour gérer les opérations sur les équipements
class Equipement {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    // Récupération de tous les équipements
    public function afficher() { 
        return $this->pdo->query("SELECT * FROM equipement ORDER BY id_eq DESC")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Ajout d'un nouvel équipement
    public function ajouter($nom, $categorie, $quantite, $image) { 
        $stmt = $this->pdo->prepare("INSERT INTO equipement (nom, categorie, quantite, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $categorie, $quantite, $image]); 
    }

    // Récupération d'un équipement spécifique par ID
    public function getById($id) { 
        $stmt = $this->pdo->prepare("SELECT * FROM equipement WHERE id_eq = ?"); 
        $stmt->execute([$id]); 
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // Mise à jour d'un équipement
    public function update($id, $nom, $categorie, $quantite, $image) { 
        $stmt = $this->pdo->prepare("UPDATE equipement SET nom = ?, categorie = ?, quantite = ?, image = ? WHERE id_eq = ?");
        return $stmt->execute([$nom, $categorie, $quantite, $image, $id]); 
    }

    // Suppression d'un équipement
    public function delete($id) { 
        $stmt = $this->pdo->prepare("DELETE FROM equipement WHERE id_eq = ?"); 
        return $stmt->execute([$id]); 
    }
}

$equipementObj = new Equipement($pdo);

// Traitement de la suppression
if (isset($_GET['action']) && $_GET['action'] == "supprimer" && isset($_GET['id'])) { 
    $equipementObj->delete(intval($_GET['id'])); 
    header("Location: equipements.php"); exit(); 
}

// Mode modification : récupération des données
$updateMode = false; 
$editData = [];
if (isset($_GET['action']) && $_GET['action'] == "modifier" && isset($_GET['id'])) { 
    $updateMode = true; 
    $editData = $equipementObj->getById(intval($_GET['id'])); 
}

// Traitement de l'enregistrement (Ajout ou Modification)
if (isset($_POST['save_equipement'])) {
    $nom = trim($_POST['nom']); 
    $categorie = trim($_POST['categorie']); 
    $quantite = intval($_POST['quantite']); 
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : ($_POST['old_image'] ?? 'default.jpg');
    
    if ($_FILES['image']['name']) { move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image); }
    
    if (!empty($nom) && !empty($categorie)) {
        if (isset($_POST['equipement_id']) && !empty($_POST['equipement_id'])) { 
            $equipementObj->update(intval($_POST['equipement_id']), $nom, $categorie, $quantite, $image); 
        } else { 
            $equipementObj->ajouter($nom, $categorie, $quantite, $image); 
        }
        header("Location: equipements.php"); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fitness Pro - Gestion Équipements</title>
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
            <li class="active"><a href="equipements.php">Équipements</a></li>
            <li><a href="coachs.php">Coachs</a></li>
            <li><a href="users.php">Utilisateur</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <header><h2>Gestion des Équipements</h2></header>
        <div class="content-container">
            
            <div class="form-section">
                <h3><?php echo $updateMode ? "Modifier le matériel" : "Ajouter un Équipement"; ?></h3>
                <form method="POST" enctype="multipart/form-data">
                    <?php 
                    if ($updateMode) { 
                        echo '<input type="hidden" name="equipement_id" value="'.$editData['id_eq'].'">';
                        echo '<input type="hidden" name="old_image" value="'.$editData['image'].'">';
                    } 
                    ?>
                    <div class="form-grid">
                        <div class="form-group"><label>Nom</label><input type="text" name="nom" value="<?php echo $updateMode ? $editData['nom'] : ''; ?>" required></div>
                        <div class="form-group"><label>Catégorie</label><input type="text" name="categorie" value="<?php echo $updateMode ? $editData['categorie'] : ''; ?>" required></div>
                        <div class="form-group"><label>Quantité</label><input type="number" name="quantite" value="<?php echo $updateMode ? $editData['quantite'] : ''; ?>" required></div>
                        <div class="form-group"><label>Image</label><input type="file" name="image"></div>
                    </div>
                    <button type="submit" name="save_equipement" class="btn-submit">Enregistrer</button>
                    <?php if ($updateMode) { echo '<a href="equipements.php" class="btn-cancel">Annuler</a>'; } ?>
                </form>
            </div>
            
            <div class="table-section">
                <table>
                    <thead><tr><th>ID</th><th>Image</th><th>Nom</th><th>Catégorie</th><th>Qté</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php
                        foreach ($equipementObj->afficher() as $eq) {
                            echo '<tr>
                                    <td>#'.$eq['id_eq'].'</td>
                                    <td><img src="../images/'.$eq['image'].'" class="table-img" style="width:50px;"></td>
                                    <td><strong>'.$eq['nom'].'</strong></td>
                                    <td>'.$eq['categorie'].'</td>
                                    <td>'.$eq['quantite'].'</td>
                                    <td>
                                        <a href="?action=modifier&id='.$eq['id_eq'].'" class="btn-edit">Modifier</a>
                                        <a href="?action=supprimer&id='.$eq['id_eq'].'" class="btn-supprimer">Supprimer</a>
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