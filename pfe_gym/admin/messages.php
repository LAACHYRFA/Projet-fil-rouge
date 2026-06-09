<?php
/**
 * Page de gestion des messages reçus
 * Permet l'affichage, la lecture (changement de statut) et la suppression
 */

session_start();
// Vérification de la session admin pour sécuriser la page
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

class Message {
    private $pdo;
    
    // Constructeur pour initialiser la connexion PDO
    public function __construct($pdo) { $this->pdo = $pdo; }

    // Récupération de tous les messages triés par ID décroissant
    public function afficher() { 
        return $this->pdo->query("SELECT * FROM message ORDER BY id_msg DESC")->fetchAll(PDO::FETCH_ASSOC); 
    }

    // Mise à jour du statut du message en 'lu'
    public function marquerCommeLu($id) { 
        $stmt = $this->pdo->prepare("UPDATE message SET statut = 'lu' WHERE id_msg = ?");
        return $stmt->execute([$id]); 
    }

    // Suppression d'un message spécifique
    public function delete($id) { 
        $stmt = $this->pdo->prepare("DELETE FROM message WHERE id_msg = ?");
        return $stmt->execute([$id]); 
    }
}

$messageObj = new Message($pdo);

// Traitement des actions (Suppression ou Lecture)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == "supprimer") $messageObj->delete($id);
    if ($_GET['action'] == "marquer_lu") $messageObj->marquerCommeLu($id);
    // Redirection après l'exécution pour éviter le renvoi du formulaire
    header("Location: messages.php"); exit();
}

$messages = $messageObj->afficher();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fitness Pro - Messages</title>
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
            <li><a href="users.php">Utilisateur</a></li>
            <li class="active"><a href="messages.php">Messages</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="content-container">
            <h2>Messages reçus</h2>
            
            <div class="table-section">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        // Vérification si la liste des messages est vide
                        if (empty($messages)) {
                            echo '<tr><td colspan="5">Aucun message pour le moment.</td></tr>';

                        } else {

                            // Boucle pour afficher chaque message
                            foreach ($messages as $msg) {
                                
                                // Définition de la classe CSS pour les messages non lus
                                $rowClass = ($msg['statut'] == 'non_lu') ? 'class="non_lu_row"' : '';
                                $btnLu = ($msg['statut'] == 'non_lu') ? '<a href="?action=marquer_lu&id='.$msg['id_msg'].'" class="btn-edit" style="margin-right:5px;">Lu</a>' : '';
                                
                                echo '<tr ' . $rowClass . '>
                                        <td><strong>' . $msg['nom'] . '</strong></td>
                                        <td>' . $msg['email'] . '</td>
                                        <td>' . nl2br($msg['contenu']) . '</td>
                                        <td>' . $msg['date_envoi'] . '</td>
                                        <td class="actions">
                                            ' . $btnLu . '
                                            <a href="?action=supprimer&id=' . $msg['id_msg'] . '" class="btn-supprimer">Supprimer</a>
                                        </td>
                                      </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>