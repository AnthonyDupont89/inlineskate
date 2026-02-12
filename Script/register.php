<?php
session_start();
require_once 'db_config.php'; // Inclut le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Vérifie si le formulaire a été soumis
    $email = $_POST['UserEmail']; // Récupère l'email depuis le formulaire
    $password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Hash le mot de passe avec BCRYPT
    $nom = $_POST['Nom']; // Récupère le nom depuis le formulaire
    $prenom = $_POST['Prenom']; // Récupère le prénom depuis le formulaire
    $adresse = $_POST['Adresse']; // Récupère l'adresse depuis le formulaire
    $codePostal = $_POST['CodePostal']; // Récupère le code postal depuis le formulaire
    $ville = $_POST['Ville']; // Récupère la ville depuis le formulaire
    $telephone = $_POST['Telephone']; // Récupère le téléphone depuis le formulaire
    $profil = $_POST['Profil']; // Récupère le profil depuis le formulaire

    // Prépare une requête SQL pour vérifier l'existence de l'email
    $checkQuery = "SELECT * FROM utilisateurs WHERE useremail = ?";
    $stmt = $conn->prepare($checkQuery); // Prépare la requête
    $stmt->bind_param("s", $email); // Lie les paramètres à la requête
    $stmt->execute(); // Exécute la requête
    $result = $stmt->get_result(); // Récupère le résultat

    if ($result->num_rows > 0) { // Si un résultat est trouvé (doublons)
        echo "L'email est déjà utilisé."; // Affiche un message d'erreur
    } else {
        // Prépare une requête SQL pour insérer les nouvelles données
        $insertQuery = "INSERT INTO utilisateurs (useremail, password, nom, prenom, adresse, codePostal, ville, telephone, profil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery); // Prépare la requête
        $stmt->bind_param("sssssssss", $email, $password, $nom, $prenom, $adresse, $codePostal, $ville, $telephone, $profil); // Lie les paramètres à la requête
        if ($stmt->execute()) { // Exécute la requête
            header("Location: ../connexion.php"); // Redirige vers la page de connexion
            exit(); // Assure l'arrêt du script après la redirection
        } else {
            echo "Erreur: " . $conn->error; // Affiche un message d'erreur en cas d'échec de l'exécution
        }
    }

    $stmt->close(); // Ferme le statement
    $conn->close(); // Ferme la connexion à la base de données
}
?>

