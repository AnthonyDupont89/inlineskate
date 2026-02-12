<?php
session_start();
require_once 'db_config.php';

// Si les données du formulaire sont soumises, ajouter le rendez-vous
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $EmailUser = $_SESSION['userEmail'];
    $Date = $_POST['Date'];
    $Heure = $_POST['Heure'];
    $NiveauCode = $_POST['NiveauCode'];
    $NombrePlaces = $_POST['NombrePlaces'];

    // Vérifier et limiter le nombre de places à 10 maximum
    if ($NombrePlaces > 10) {
        $NombrePlaces = 10;
    }

    $sql = "INSERT INTO seancescours (EmailUser, Date, Heure, NiveauCode, NombrePlaces) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $EmailUser, $Date, $Heure, $NiveauCode, $NombrePlaces);

    if ($stmt->execute()) {
        echo "Nouveau rendez-vous ajouté avec succès";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();

    // Rediriger vers la page d'accueil après l'ajout
    header("Location: ../agenda_moniteur.php");
    exit();
}


$stmt->close();
$conn->close();
?>
