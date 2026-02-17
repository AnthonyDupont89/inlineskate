<section class="inscription-container">
    <div class="inscription-content">
        <form class="inscription-form" action="/register" method="post">
            <h2>Inscription</h2>

            <?php if (!empty($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <label for="last_name">Nom :</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="first_name">Prénom :</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" required>

            <label for="postal_code">Code Postal :</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required>

            <label for="phone">Téléphone :</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="role">Profil :</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>-- Sélectionnez un profil --</option>
                <option value="student">Élève</option>
                <option value="instructor">Moniteur</option>
            </select>

            <button type="submit">S'inscrire</button>
        </form>

        <img class="inscription-image" src="/images/inscription.avif" alt="Inscription">
    </div>
</section>
