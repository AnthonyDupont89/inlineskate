<?php
session_start();
require_once 'db_config.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userEmail = $_POST['userEmail'];
    $password = $_POST['password'];

    // Prépare une requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare('SELECT UserEmail, password, profil FROM utilisateurs WHERE UserEmail = ?');
    
    // Lie les paramètres
    $stmt->bind_param('s', $userEmail);
    
    // Exécute la requête
    $stmt->execute();
    
    // Stocke le résultat
    $stmt->store_result();

    // Vérifie si l'utilisateur existe
    if ($stmt->num_rows > 0) {
        // Lie les résultats de la requête aux variables
        $stmt->bind_result($retrievedUserEmail, $hashed_password, $profil);
        $stmt->fetch();

        // Vérifie le mot de passe
        if (password_verify($password, $hashed_password)) {
            // Connexion réussie
            $_SESSION['userEmail'] = $retrievedUserEmail;
            $_SESSION['profil'] = $profil;

            // Redirection basée sur le profil
            switch ($profil) {
                case 'ADM':
                    header('Location: ../agenda_admin.php');
                    break;
                case 'MNT':
                    header('Location: ../agenda_moniteur.php');
                    break;
                case 'ELV':
                    header('Location: ../agenda_eleve.php');
                    break;
                default:
                    echo "Profil inconnu";
                    break;
            }
            exit();
        } else {
            // Mot de passe incorrect
            echo "Mot de passe incorrect";
        }
    } else {
        // Utilisateur non trouvé
        echo "Adresse email incorrecte";
    }

    // Ferme la requête préparée
    $stmt->close();
}

// Ferme la connexion à la base de données
$conn->close();
?>
