<h2>Ajouter une séance de cours</h2>
<form action="/agenda/store" method="post">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

    <label for="date">Date :</label>
    <input type="date" id="date" name="date" required>

    <label for="time">Heure :</label>
    <input type="time" id="time" name="time" required>

    <label for="level_code">Niveau :</label>
    <select id="level_code" name="level_code" required>
        <option value="" disabled selected>-- Sélectionnez un niveau --</option>
        <?php foreach ($levels as $level): ?>
            <option value="<?= htmlspecialchars($level['code']) ?>">
                <?= htmlspecialchars($level['name']) ?> (<?= htmlspecialchars($level['price']) ?> &euro;)
            </option>
        <?php endforeach; ?>
    </select>

    <label for="max_spots">Places :</label>
    <input type="number" id="max_spots" name="max_spots" min="1" max="10" required>

    <button type="submit">Ajouter</button>
</form>

<h2>Mes séances de cours</h2>
<table class="agenda-table">
    <tr>
        <th>Date</th>
        <th>Heure</th>
        <th>Niveau</th>
        <th>Inscrits</th>
    </tr>
    <?php if (!empty($lessons)): ?>
        <?php foreach ($lessons as $lesson): ?>
            <tr>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($lesson['date']))) ?></td>
                <td><?= htmlspecialchars(date('H:i', strtotime($lesson['time']))) ?></td>
                <td><?= htmlspecialchars($lesson['level']) ?></td>
                <td><?= htmlspecialchars($lesson['enrolled_count']) ?>/<?= htmlspecialchars($lesson['max_spots']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="4">Aucune séance créée.</td></tr>
    <?php endif; ?>
</table>
