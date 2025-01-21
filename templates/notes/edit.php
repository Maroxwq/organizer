<div class="errors">
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="error"><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<form method="POST" action="/notes/update">
    <input type="hidden" name="id" value="<?= $note->getId() ?>">
    <div>
        <label for="content">Контент:</label>
        <textarea id="content" name="content"><?= $note->getContent() ?></textarea>
    </div>
    <div>
        <label for="color">Цвет:</label>
        <input type="color" id="color" name="color" value="<?= $note->getColor() ?>">
    </div>
    <button type="submit">Сохранить</button>
</form>