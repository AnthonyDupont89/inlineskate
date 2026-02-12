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

        <main class="connexion-container">
            <div class="connexion-text">
                <h2>Connexion</h2>
                    <form action="Script\login.php" method="post">
                        <label for="userEmail">Adresse email :</label>
                        <input type="email" id="userEmail" name="userEmail" required><br><br>
                        
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required><br><br>
                        
                        <button type="submit">Se connecter</button>
                    </form>

                <h2>Tu n'as pas encore de compte?</h2>
                    <p>Alors inscris-toi en cliquant sur le bouton : <a href="inscription.php">inscription</a></p>
            </div>

            <div class="connexion-img">
                <img src="Images\connexion.avif" alt="">
            </div>

            
            
        </main>

        <footer>
            <?php
            include_once 'template\footer.php';
            ?>
        </footer>
    </body>
</html>
