<?php
session_start();
require "connexion.php";

// 1. حماية الصفحة: يلا ماكانش داير Login يرجع لـ login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. جلب البيانات من الـ Session والوقت ديال دابا
$id_user = $_SESSION['user_id'];
$id_abonnement = isset($_SESSION['id_abonnement']) ? $_SESSION['id_abonnement'] : "Aucun abonnement sélectionné";
$date_reservation = date('Y-m-d H:i:s'); // تاريخ ووقت الحجز الحالي

// 3. فاش يكليكي المستخدم على زر التأكيد النهائي
if (isset($_POST['confirmer'])) {
    if (isset($_SESSION['id_abonnement'])) {
        try {
            // إدخال الحجز ف جدول الـ reservation ف الداتابيز
            $stmt = $pdo->prepare("INSERT INTO reservation (id_utilisateur, id_ab, date_reservation) VALUES (?, ?, NOW())");
            $stmt->execute([$id_user, $_SESSION['id_abonnement']]);

            // مسح السيسيون حيت صافي سجلناه ف الداتابيز
            unset($_SESSION['id_abonnement']);

            echo "<script>alert('Réservation enregistrée avec succès !'); window.location.href='index.php';</script>";
            exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
    <link rel="stylesheet" href="css/reservation.css">
    
</head>
<body>

    <div class="reservation-container">
        
        <h2>Récapitulatif de votre Réservation</h2>

        <ul>
            <li>
                <strong>ID Utilisateur :</strong> 
                <span class="highlight-value"># <?php echo $id_user; ?></span>
            </li>
            <li>
                <strong>ID Abonnement :</strong> 
                <span class="highlight-value"># <?php echo $id_abonnement; ?></span>
            </li>
            <li>
                <strong>Date de Réservation :</strong> 
                <span class="highlight-value"><?php echo $date_reservation; ?></span>
            </li>
        </ul>

       <form method="POST">
    <button type="submit" name="confirmer" class="btn-submit">Confirmer la réservation</button>
</form>

<div class="actions">
    <a href="abonnements.php" class="link-annuler">Annuler</a>
    <span style="color: #ccc;">|</span>
    <a href="logout.php" class="link-logout">Déconnexion</a>
</div>

</body>
</html>