<div class="connexion-container">
    <div class="connexion-text">
        <h2>Connexion</h2>

        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="/login" method="post">
            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <h2>Tu n'as pas encore de compte ?</h2>
        <p>Alors inscris-toi en cliquant sur le bouton : <a href="/register">inscription</a></p>
    </div>

    <div class="connexion-img">
        <img src="/images/connexion.avif" alt="Connexion">
    </div>
</div>
