<?php
session_start();
require_once 'db_config.php'; // Inclut le fichier de connexion à la base de données

// Récupérer les valeurs ENUM de la colonne 'profil'
$sql = "SHOW COLUMNS FROM utilisateurs LIKE 'profil'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $enumValues = $row['Type']; // e.g. "enum('ADM','MNT','ELV')"
    
    // Extraire les valeurs ENUM
    preg_match("/^enum\(\'(.*)\'\)$/", $enumValues, $matches);
    $enumValues = explode("','", $matches[1]); // e.g. ['ADM', 'MNT', 'ELV']
} else {
    die("Erreur : Impossible de récupérer les valeurs ENUM.");
}

// Fermer la connexion
$conn->close();

// Tableau associatif pour mapper les valeurs ENUM aux libellés lisibles
$enumLabels = [
    'ADM' => 'Administrateur',
    'MNT' => 'Moniteur',
    'ELV' => 'Élève'
];

?>


