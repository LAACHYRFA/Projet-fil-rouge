<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
require "../connexion.php";

class DashboardStats {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }
    public function countRows($table) {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM $table");
        return $stmt->fetchColumn();
    }
}

$statsObj = new DashboardStats($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fitness Pro - Dashboard</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">FITNESS PRO</div>
        <ul class="sidebar-menu">
            <li class="active"><a href="dashboard.php">Dashboard</a></li>
            <li><a href="abonnemnts.php">Abonnements</a></li>
            <li><a href="equipements.php">Équipements</a></li>
            <li><a href="coachs.php">Coachs</a></li>
            <li><a href="users.php">Utilisateur</a></li>
            <li><a href="messages.php">Messages</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="content-container">
            
            <h2 class="dashboard-title">Dashboard</h2>
            
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-icon">💳</div>
                    <h1><?= $statsObj->countRows("abonnement") ?></h1>
                    <p>Forfaits</p>
                </div>
                <div class="card">
                    <div class="card-icon">👤</div>
                    <h1><?= $statsObj->countRows("coach") ?></h1>
                    <p>Coachs</p>
                </div>
                <div class="card">
                    <div class="card-icon">✉️</div>
                    <h1><?= $statsObj->countRows("message") ?></h1>
                    <p>Messages</p>
                </div>
                <div class="card">
                    <div class="card-icon">👥</div>
                    <h1><?= $statsObj->countRows("utilisateur") ?></h1>
                    <p>Utilisateurs</p>
                </div>
                <div class="card">
                    <div class="card-icon">🏋️</div>
                    <h1><?= $statsObj->countRows("equipement") ?></h1>
                    <p>Équipements</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>