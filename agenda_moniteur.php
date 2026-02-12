<?php
session_start();

if (!isset($_SESSION['userEmail']) || $_SESSION['profil'] !== 'MNT') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <body>
        <header>
            <?php
            include_once 'template\header.php';
            ?>
        </header>
        <main>
            <!-- <h1>Bienvenue dans votre agenda</h1>
                <p>
                Votre adresse email: <?php echo htmlspecialchars($_SESSION['userEmail']); ?> <br>
                Votre profil: <?php echo htmlspecialchars($_SESSION['profil']); ?></p> -->

            <h2>Ajouter une séance de cours</h2>
                <form action="Script\cours.php" method="post">
                    
                    <label for="Date">Date :</label>
                    <input type="date" id="Date" name="Date" required><br>

                    <label for="Heure">Heure :</label>
                    <input type="time" id="Heure" name="Heure" required><br>

                    <label for="NiveauCode">Niveau :</label>
                        <select id="NiveauCode" name="NiveauCode" required>
                            <option value="" disabled selected>-- Sélectionnez un niveau --</option>
                            <?php
                            require_once 'Script\niveaux.php'
                            ?>
                        </select><br>
                    
                    <label for="NombrePlaces">Places :</label>
                    <input type="number" id="NombrePlaces" name="NombrePlaces" min="1" max="10" required><br>

                    <input type="submit" value="Ajouter">
                </form>

            <h2>Liste de mes séances de cours</h2>
            <div class="agenda-table-container">
            <table class="agenda-table">
                <tr>
                    <th>Séance</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Niveau</th>
                    <th>Participants</th> <!-- Nouvelle colonne -->
                    <th>Élèves</th> <!-- Colonne déplacée -->
                </tr>

                <?php
                require_once 'Script/db_config.php';

                $userEmail = $_SESSION['userEmail'];
                
                $sql = "SELECT sc.IDseance, sc.Date, sc.Heure, sc.NiveauCode, sc.NombrePlaces, nc.Description
                        FROM seancescours sc
                        JOIN niveauxcours nc ON sc.NiveauCode = nc.CodeNiveau
                        WHERE sc.EmailUser = ?  -- Filtre pour l'email du moniteur connecté
                        ORDER BY sc.Date ASC, sc.Heure ASC";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $userEmail); // Lier le paramètre userEmail
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Récupération du nombre de participants pour cette séance
                        $seance_id = $row['IDseance'];
                        $nombre_places = $row['NombrePlaces']; // Nombre maximum de places
                        $sql_participants = "SELECT COUNT(*) AS nombre_participants FROM inscriptions WHERE SeanceID = ?";
                        $stmt_participants = $conn->prepare($sql_participants);
                        $stmt_participants->bind_param("i", $seance_id);
                        $stmt_participants->execute();
                        $result_participants = $stmt_participants->get_result();
                        $participant_row = $result_participants->fetch_assoc();
                        $nombre_participants = $participant_row['nombre_participants'];

                        // Récupération des participants pour cette séance
                        $participants = "";
                        $sql_all_participants = "SELECT EmailUser FROM inscriptions WHERE SeanceID = ?";
                        $stmt_all_participants = $conn->prepare($sql_all_participants);
                        $stmt_all_participants->bind_param("i", $seance_id);
                        $stmt_all_participants->execute();
                        $result_all_participants = $stmt_all_participants->get_result();
                        while ($participant_row = $result_all_participants->fetch_assoc()) {
                            $participants .= htmlspecialchars($participant_row['EmailUser']) . ', ';
                        }
                        $participants = rtrim($participants, ', '); // Supprime la virgule finale

                        echo "<tr>
                                <td>" . htmlspecialchars($row["IDseance"]) . "</td>
                                <td>" . htmlspecialchars(date("d-m-Y", strtotime($row["Date"]))) . "</td>
                                <td>" . htmlspecialchars(date("H:i", strtotime($row["Heure"]))) . "</td>
                                <td>" . htmlspecialchars($row["Description"]) . "</td>
                                <td>" . htmlspecialchars($nombre_participants) . "/" . htmlspecialchars($nombre_places) . "</td>
                                <td>" . htmlspecialchars($participants) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun rendez-vous trouvé</td></tr>";
                }

                $conn->close();
                ?>
            </table>
        </main>

        <footer>
            <?php
            include_once 'template\footer.php';
            ?>
        </footer>
    </body>
</html>

