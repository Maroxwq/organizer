<div class="errors">
    <ul>
        <?php foreach ($errors as $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <li class="text-danger"><?= $error ?></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</div>
<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <h2 class="text-center mb-4">Добавить заметку</h2>
        <form action="/notes/add" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="content" name="content" value="<?= htmlspecialchars($note->getContent()) ?>" placeholder="Введите текст">
                <label for="content">Текст</label>
            </div>
            <div class="form-floating mb-3">
                <input type="color" class="form-control" id="color" name="color" value="<?= $note->getColor() ?>">
                <label for="color">Цвет</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Сохранить</button>
        </form>
    </div>
</div>