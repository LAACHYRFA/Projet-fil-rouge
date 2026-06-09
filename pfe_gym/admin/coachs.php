<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

// ==========================================================================
// كلاس الـ POO الموحد لإدارة المدربين (Coachs)
// ==========================================================================
class Coach {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    public function afficher() { 
        return $this->pdo->query("SELECT * FROM coach ORDER BY id_coach DESC")->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function ajouter($nom, $image, $spec, $email, $tel) { 
        $stmt = $this->pdo->prepare("INSERT INTO coach (nom_complet, image, specialite, email, telephone) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $image, $spec, $email, $tel]); 
    }

    public function getById($id) { 
        $stmt = $this->pdo->prepare("SELECT * FROM coach WHERE id_coach = ?"); 
        $stmt->execute([$id]); 
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function update($id, $nom, $image, $spec, $email, $tel) { 
        $stmt = $this->pdo->prepare("UPDATE coach SET nom_complet=?, image=?, specialite=?, email=?, telephone=? WHERE id_coach=?");
        return $stmt->execute([$nom, $image, $spec, $email, $tel, $id]); 
    }

    public function delete($id) { 
        $stmt = $this->pdo->prepare("DELETE FROM coach WHERE id_coach = ?"); 
        return $stmt->execute([$id]); 
    }
}

$coachObj = new Coach($pdo);

// معالجة الحذف
if (isset($_GET['action']) && $_GET['action'] == "supprimer" && isset($_GET['id'])) { 
    $coachObj->delete(intval($_GET['id'])); 
    header("Location: coachs.php"); exit(); 
}

// معالجة التعديل (جلب البيانات)
$updateMode = false; $editData = [];
if (isset($_GET['action']) && $_GET['action'] == "modifier" && isset($_GET['id'])) { 
    $updateMode = true; 
    $editData = $coachObj->getById(intval($_GET['id'])); 
}

// معالجة الحفظ
if (isset($_POST['save_coach'])) {
    $nom = trim($_POST['nom']); $spec = trim($_POST['spec']); $email = trim($_POST['email']); $tel = trim($_POST['telephone']);
    $image = $_FILES['img']['name'] ? time().$_FILES['img']['name'] : ($_POST['old_img'] ?? '');
    
    if ($_FILES['img']['name']) { move_uploaded_file($_FILES['img']['tmp_name'], "../images/".$image); }
    
    if (!empty($nom) && !empty($email)) {
        if (isset($_POST['coach_id']) && !empty($_POST['coach_id'])) { 
            $coachObj->update(intval($_POST['coach_id']), $nom, $image, $spec, $email, $tel); 
        } else { 
            $coachObj->ajouter($nom, $image, $spec, $email, $tel); 
        }
        header("Location: coachs.php"); exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Coachs</title>
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
            <li class="active"><a href="coachs.php">Coachs</a></li>
            <li><a href="users.php">Utilisateur</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header><h2>Gestion des Coachs</h2></header>
        <div class="content-container">
            <div class="form-section">
                <h3><?= $updateMode ? "Modifier le coach" : "Ajouter un coach" ?></h3>
                <form method="POST" enctype="multipart/form-data">
                    <?php if($updateMode): ?>
                        <input type='hidden' name='coach_id' value='<?= $editData['id_coach'] ?>'>
                        <input type='hidden' name='old_img' value='<?= $editData['image'] ?>'>
                    <?php endif; ?>
                    <div class="form-grid">
                        <div class="form-group"><label>Nom complet</label><input type="text" name="nom" value="<?= $updateMode ? $editData['nom_complet'] : '' ?>" required></div>
                        <div class="form-group"><label>Spécialité</label><input type="text" name="spec" value="<?= $updateMode ? $editData['specialite'] : '' ?>" required></div>
                        <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= $updateMode ? $editData['email'] : '' ?>" required></div>
                        <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" value="<?= $updateMode ? $editData['telephone'] : '' ?>" required></div>
                        <div class="form-group full-width"><label>Image</label><input type="file" name="img"></div>
                    </div>
                    <button type="submit" name="save_coach" class="btn-submit"><?= $updateMode ? "Modifier" : "Ajouter" ?></button>
                    <?php if($updateMode): ?><a href="coachs.php" class="btn-cancel">Annuler</a><?php endif; ?>
                </form>
            </div>

            <div class="table-section">
                <table>
                    <thead><tr><th>Image</th><th>Nom</th><th>Spécialité</th><th>Contact</th><th>Actions</th></tr></thead>
                    <tbody>
                        <?php foreach($coachObj->afficher() as $c): ?>
                        <tr>
                            <td><img src="/pfe_gym/<?php echo htmlspecialchars($c['image']); ?>" class="table-img"></td>
                            <td><strong><?= $c['nom_complet'] ?></strong></td>
                            <td><?= $c['specialite'] ?></td>
                            <td><?= $c['email'] ?><br><small><?= $c['telephone'] ?></small></td>
                            <td>
                                <a href="?action=modifier&id=<?= $c['id_coach'] ?>" class="btn-edit">Modifier</a>
                                <a href="?action=supprimer&id=<?= $c['id_coach'] ?>" class="btn-supprimer" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>