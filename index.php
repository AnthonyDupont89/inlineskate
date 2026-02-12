<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <body>
        <header>
            <?php
            include_once 'template\header.php';
            ?>
        </header>

        <main>
            <img src="Images\index.jpg" alt="">
            <h2>Salutation</h2>
                <p>"Bienvenue à toi,<br><br>
                Ici on va te parler de roller, d'aventures et de comment toi aussi tu vas bientôt pouvoir partir
                en escapade dans ta ville ou ailleurs, grace à nos cours.<br><br>

                Si tu es curieux et que tu veux en apprendre plus sur nous, notre projet et ce qu'on propose, alors on t'invite
                à parcourir notre site. Le voyage commence ici, on t'attend dans les prochaines pages, à toute suite!"<br><br>

                Pour faire connaissance, tu peux aller à la page <a href="about.php">à propos</a>.

                <!--Signé la team <span>inline</span> -->


                </p>
        </main>

        <footer>
            <?php
            include_once 'template\footer.php';
            ?>
        </footer>
    </body>
</html>
