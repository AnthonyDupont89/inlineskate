<?php
session_start(); // Assurez-vous que la session est démarrée
require_once 'db_config.php'; // Inclure le fichier de configuration de la base de données


// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['userEmail'])) {
    echo "Session utilisateur non valide.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données POST
    $IDseance = $_POST['IDseance'];
    $emailUser = $_SESSION['userEmail'];

    // Préparez et exécutez la requête pour supprimer l'inscription
    $sql = "DELETE FROM inscriptions WHERE SeanceID = ? AND EmailUser = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("is", $IDseance, $emailUser);
        if ($stmt->execute()) {
            header('Location: ../agenda_eleve.php');
            exit;
            echo "Votre inscription a été annulée avec succès.";
        } else {
            echo "Erreur lors de l'annulation de votre inscription.";
        }
        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête.";
    }

    $conn->close();
} else {
    echo "Méthode de requête non valide.";
}
?>
