<?php
session_start();
require_once 'db_config.php'; // Inclut le fichier de connexion à la base de données

// Requête pour récupérer les niveaux
$sql = "SELECT CodeNiveau, description FROM niveauxcours ORDER BY OrdreNiveau";
$result = $conn->query($sql);

// Générer les options dynamiques
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["CodeNiveau"] . "'>" . $row["description"] . "</option>";
    }
} else {
    echo "<option value='' disabled>Aucun niveau trouvé</option>";
}

?>