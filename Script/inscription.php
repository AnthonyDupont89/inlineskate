<?php
session_start();
require_once 'db_config.php';

// Vérifier si des données POST ont été soumises pour l'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['IDseance'])) {
    // Récupérer et sécuriser l'ID de la séance depuis les données POST
    $IDseance = htmlspecialchars($_POST['IDseance']);
    
    // Vérifier si l'utilisateur est connecté via une session
    if (isset($_SESSION['userEmail'])) {
        $emailUser = $_SESSION['userEmail'];

        // Vérifier à nouveau si l'utilisateur est déjà inscrit (par sécurité)
        $checkStmt = $conn->prepare("SELECT * FROM inscriptions WHERE SeanceID = ? AND EmailUser = ?");
        $checkStmt->bind_param("is", $IDseance, $emailUser);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo "Vous êtes déjà inscrit à cette séance.";
        } else {
            // Préparer la requête d'insertion dans la table des inscriptions
            $insertStmt = $conn->prepare("INSERT INTO inscriptions (SeanceID, EmailUser) VALUES (?, ?)");
            $insertStmt->bind_param("is", $IDseance, $emailUser);
            
            if ($insertStmt->execute()) { // Exécuter la requête d'insertion
                header('Location: ../agenda_eleve.php');
                exit;
                echo "Inscription réussie."; // Afficher un message de succès si l'inscription est réussie
            } else {
                echo "Erreur lors de l'inscription."; // Afficher un message d'erreur si l'inscription échoue
            }

            $insertStmt->close();
        }

        $checkStmt->close();
    } else {
        echo "Session utilisateur non valide."; // Gérer le cas où l'utilisateur n'est pas connecté
    }
}

?>