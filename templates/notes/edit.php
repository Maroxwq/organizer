<?php if ($msg = $note->getError('content')): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <h2 class="text-center mb-4">Редактировать заметку</h2>
        <form method="POST" action="/notes/edit/<?= $note->getId() ?>">
            <div class="form-floating mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="Введите текст" style="height: 100px;"><?= htmlspecialchars($note->getContent()) ?></textarea>
                <label for="content">Контент</label>
            </div>
            <div class="form-floating mb-3">
                <input type="color" class="form-control" id="color" name="color" value="<?= $note->getColor() ?>" style="height: 58px;">
                <label for="color">Цвет</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Сохранить</button>
        </form>
    </div>
</div>
