<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <body>
        <header>
            <?php
            include_once 'template\header.php';
            ?>
        </header>

        <main>

            <img src="Images\about.jpg" alt="">
            
            <section class="section">
                <h2>Présentation</h2>
                <div class="content">
                    <p>
                        "Ça, c'est nous! <br><br>
                        Le gars avec le t-shirt jaune, il s'appelle Paul.
                        Il fait un double "V" de la victoire parce qu'il est content :
                        d'habitude c'est lui le photographe et du coup on le voit pas souvent sur les photos.
                        <br><br>
                        Moi c'est Jacques, j'aime bien le café et écrire. C'est moi qui m'occupe de la rédaction, du site et de nos réseaux
                        (n'hésite pas à aller y faire un tour pour suivre les news).
                        <br><br>
                        Et en dernier (dans la section projet), c'est Pierre. 
                        Il gère la logistique et c'est lui qui organise, notamment, nos voyages. <br>
                        C'est un gars ponctuel, mais pas moi : je suis en retard et il m'attendent pour partir."
                    </p>
                    <img src="Images\jacques.avif" alt="Photo de Jacques">
                </div>
            </section>

            <!-- Section Le projet -->
            <section class="section">
                <h2>Le projet</h2>
                <div class="content">
                    <p>
                        "Au départ, on est trois copains qui avons passés notre enfance à arpenter les rues de Bruxelles dans nos rollers, en soif de liberté.<br><br>
                        En grandissant, on a voulu élargir notre terrain de jeu : on a découvert les R.A.V.E.L. et progressivement, 
                        on a visité la Belgique et ses différentes villes en empruntant son réseau de piste cyclable.
                        L'idée de voyager à roller dans d'autres pays nous est venue naturellement et aujourd'hui, on a envie de partager cette expérience.
                        <br><br>Ce projet est donc né d'une envie de partager notre passion pour le roller et notre engouement pour le voyage.
                        C'est donc avec enthousiasme qu'on a hâte de te rencontrer et de t'emmener avec nous dans nos prochaines aventures.
                        Car oui, nous comptons bien te faire découvrir le plaisir de voyager à roller en organisant entre autre des city trip.<br><br>
                        Pour en savoir plus, rendez-vous sur notre page <a href="cours.php">cours</a>".
                    </p>
                    <img src="Images\pierre.avif" alt="Photo de Pierre">
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

