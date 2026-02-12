<nav>
    <h1>inline</h1>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="about.php">À propos</a></li>
        <li><a href="cours.php">Cours</a></li>

        <?php if (isset($_SESSION['userEmail'])): ?>
            <?php if ($_SESSION['profil'] == 'ADM'): ?>
                <li><a href="agenda_admin.php">Agenda</a></li>
            <?php elseif ($_SESSION['profil'] == 'MNT'): ?>
                <li><a href="agenda_moniteur.php">Agenda</a></li>
            <?php elseif ($_SESSION['profil'] == 'ELV'): ?>
                <li><a href="agenda_eleve.php">Agenda</a></li>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!isset($_SESSION['userEmail'])): ?>   
            <li><a href="connexion.php">Connexion</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['userEmail'])): ?>
            <li><a href="Script/logout.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>
