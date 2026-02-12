<?php
session_start();

if (!isset($_SESSION['userEmail']) || $_SESSION['profil'] !== 'ELV') {
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
            include_once 'template/header.php';
            ?>
        </header>

        <main>
            <h2>Séances dispo</h2>
            <div class="agenda-table-container">
            <table class="agenda-table">
                <tr>
                    <th>Séance</th>
                    <th>Moniteur</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Niveau</th>
                    <th>Places diponnibles</th> <!-- Nouvelle colonne -->
                    <th>Inscription</th>
                </tr>
                <?php
                require_once 'Script/db_config.php';

                if (isset($_SESSION['userEmail'])) {
                    $emailUser = $_SESSION['userEmail'];

                    // Requête pour obtenir les séances disponibles avec la description du niveau de cours
                    $sql = "SELECT sc.IDseance, sc.EmailUser, sc.Date, sc.Heure, sc.NiveauCode, nc.Description AS NiveauDescription, sc.NombrePlaces
                            FROM seancescours sc
                            JOIN niveauxcours nc ON sc.NiveauCode = nc.CodeNiveau
                            WHERE sc.IDseance NOT IN (SELECT SeanceID FROM inscriptions WHERE EmailUser = ?)
                            ORDER BY sc.Date ASC, sc.Heure ASC";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $emailUser);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Récupération du nombre de participants inscrits pour cette séance
                            $seance_id = $row['IDseance'];
                            $sql_participants = "SELECT COUNT(*) AS nombre_participants FROM inscriptions WHERE SeanceID = ?";
                            $stmt_participants = $conn->prepare($sql_participants);
                            $stmt_participants->bind_param("i", $seance_id);
                            $stmt_participants->execute();
                            $result_participants = $stmt_participants->get_result();
                            $participant_row = $result_participants->fetch_assoc();
                            $nombre_participants = $participant_row['nombre_participants'];

                            // Calcul des places restantes
                            $places_restantes = $row['NombrePlaces'] - $nombre_participants;

                            echo "<tr>
                                    <td>" . htmlspecialchars($row["IDseance"]) . "</td>
                                    <td>" . htmlspecialchars($row["EmailUser"]) . "</td>
                                    <td>" . htmlspecialchars(date("d-m-Y", strtotime($row["Date"]))) . "</td>
                                    <td>" . htmlspecialchars(date("H:i", strtotime($row["Heure"]))) . "</td>
                                    <td>" . htmlspecialchars($row["NiveauDescription"]) . "</td> <!-- Nouvelle cellule pour Description -->
                                    <td>" . htmlspecialchars($places_restantes) . "</td> <!-- Nouvelle cellule -->
                                    <td>
                                        <form action='Script/inscription.php' method='POST'>
                                            <input type='hidden' name='IDseance' value='" . htmlspecialchars($row["IDseance"]) . "' />
                                            <button type='submit'>S'inscrire</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Aucun cours disponible</td></tr>"; // Modifié pour 7 colonnes
                    }

                    $stmt->close();
                } else {
                    echo "<tr><td colspan='7'>Session utilisateur non valide.</td></tr>"; // Modifié pour 7 colonnes
                }
                ?>
            </table>

            <h2>Séances auxquelles tu t'es inscrit</h2>
            <div class="agenda-table-container">
            <table class="agenda-table">
                <tr>
                    <th>IDseance</th>
                    <th>Moniteur</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Niveau</th>
                    <th>Annulation</th>
                </tr>
                <?php
                if (isset($_SESSION['userEmail'])) {
                    $emailUser = $_SESSION['userEmail'];

                    // Requête pour obtenir les séances auxquelles l'utilisateur est inscrit, avec la description du niveau de cours
                    $sql = "SELECT sc.IDseance, sc.EmailUser, sc.Date, sc.Heure, nc.Description AS NiveauDescription
                            FROM seancescours sc
                            JOIN inscriptions ins ON sc.IDseance = ins.SeanceID
                            JOIN niveauxcours nc ON sc.NiveauCode = nc.CodeNiveau
                            WHERE ins.EmailUser = ?
                            ORDER BY sc.Date ASC, sc.Heure ASC";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $emailUser);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["IDseance"]) . "</td>
                                    <td>" . htmlspecialchars($row["EmailUser"]) . "</td>
                                    <td>" . htmlspecialchars(date("d-m-Y", strtotime($row["Date"]))) . "</td>
                                    <td>" . htmlspecialchars(date("H:i", strtotime($row["Heure"]))) . "</td>
                                    <td>" . htmlspecialchars($row["NiveauDescription"]) . "</td> <!-- Nouvelle cellule pour Description -->
                                    <td>
                                        <form action='Script/annulation.php' method='POST'>
                                            <input type='hidden' name='IDseance' value='" . htmlspecialchars($row["IDseance"]) . "' />
                                            <button type='submit'>Annuler</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Vous n'êtes inscrit à aucun cours.</td></tr>";
                    }

                    $stmt->close();
                } else {
                    echo "<tr><td colspan='6'>Session utilisateur non valide.</td></tr>";
                }

                // Fermer la connexion après avoir exécuté toutes les requêtes
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


