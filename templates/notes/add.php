<div class="errors">
    <ul>
        <?php foreach ($errors as $error): ?>
            <li class="error"><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<form action="/notes/save" method="post">
    <div>
        <label for="content">текст</label>
        <input id="content" name="content" value="<?= htmlspecialchars($content) ?>">
    </div>
    <div>
        <label for="color">цвет</label>
        <input type="color" id="color" name="color" placeholder="#000000" value="<?= htmlspecialchars($color) ?>">
    </div>
    <button type="submit">Сохранить</button>
</form>