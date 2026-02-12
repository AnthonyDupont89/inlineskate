<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <body>
        <header>
            <?php
            include_once 'template\header.php';
            ?>
        </header>

        <main>
            <section class="inscription-container">
                <div class="inscription-content">

                    <form class="inscription-form" action="Script/register.php" method="post">
                    <h2>Inscription</h2>
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="UserEmail" required><br>

                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="Password" required><br>

                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="Nom" required><br>

                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="Prenom" required><br>

                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="Adresse" required><br>

                        <label for="codepostal">Code Postal :</label>
                        <input type="text" id="codepostal" name="CodePostal" required><br>

                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="Ville" required><br>

                        <label for="telephone">Téléphone :</label>
                        <input type="tel" id="telephone" name="Telephone" required><br>

                    
                        <label for="profil">Profil :</label>
                        <select id="profil" name="Profil" required>
                            <option value="" disabled selected>-- Sélectionnez un profil --</option>
                            <?php
                            require_once 'Script\profil.php';

                            // Générer dynamiquement les options du formulaire avec les libellés lisibles
                            foreach ($enumValues as $value) {
                                echo "<option value=\"$value\">" . $enumLabels[$value] . "</option>";
                            }
                            ?>
                        </select><br>
                        <input type="submit" value="S'inscrire">
                    </form>
                    
                    <img class="inscription-image" src="Images\inscription.avif" alt="" class="inscription-image">
                    

                </div>
            </section>
        </main>

        <footer>
            <?php
            include_once 'template\footer.php';
            ?>
        </footer>
    </body>
</html>
