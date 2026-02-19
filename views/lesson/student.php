<h2>Séances disponibles</h2>
<table class="agenda-table">
    <tr>
        <th>Moniteur</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Niveau</th>
        <th>Places</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($available)): ?>
        <?php foreach ($available as $lesson): ?>
            <tr>
                <td><?= htmlspecialchars($lesson['instructor_email']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($lesson['date']))) ?></td>
                <td><?= htmlspecialchars(date('H:i', strtotime($lesson['time']))) ?></td>
                <td><?= htmlspecialchars($lesson['level']) ?></td>
                <td><?= htmlspecialchars($lesson['available_spots']) ?></td>
                <td>
                    <form action="/agenda/enroll" method="post">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lesson['id']) ?>">
                        <button type="submit">S'inscrire</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">Aucune séance disponible.</td></tr>
    <?php endif; ?>
</table>

<h2>Mes inscriptions</h2>
<table class="agenda-table">
    <tr>
        <th>Moniteur</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Niveau</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($enrolled)): ?>
        <?php foreach ($enrolled as $lesson): ?>
            <tr>
                <td><?= htmlspecialchars($lesson['instructor_email']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($lesson['date']))) ?></td>
                <td><?= htmlspecialchars(date('H:i', strtotime($lesson['time']))) ?></td>
                <td><?= htmlspecialchars($lesson['level']) ?></td>
                <td>
                    <form action="/agenda/cancel" method="post">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lesson['id']) ?>">
                        <button type="submit">Annuler</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">Aucune inscription.</td></tr>
    <?php endif; ?>
</table>
