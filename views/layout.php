<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inline Skate</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header>
    <nav>
      <h1>inline</h1>
      <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="/about">À propos</a></li>
        <li><a href="/courses">Cours</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="/agenda">Agenda</a></li>
          <li><a href="/logout">Déconnexion</a></li>
        <?php else: ?>
          <li><a href="/login">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <?= $content ?>
  </main>

  <footer>
    <div class="footer-container">
      <div class="social-icons">
        <a href="https://www.instagram.com" target="_blank">
            <img src="/images/instagram.png" alt="Instagram">
        </a>
        <a href="https://www.facebook.com" target="_blank">
            <img src="/images/facebook.jpg" alt="Facebook">
        </a>
        <a href="https://www.twitter.com" target="_blank">
            <img src="/images/x.jpeg" alt="X">
        </a>
      </div>
    </div>
  </footer>
</body>
</html>