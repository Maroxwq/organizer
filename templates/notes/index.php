<?php
/**
 * @var Org\Model\Note[] $notes
 * @var string|null $message
 */
?>
<div class="text-center">
    <a href="/notes/add" class="btn btn-primary btn-lg mb-3 mt-4">Добавить заметку</a>
</div>
<?php if (!empty($message)): ?>
  <div class="alert alert-success" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>
<div class="container d-flex flex-wrap" style="justify-content: space-around;">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded myowncard" style="background-color: <?= $note->getColor() ?>;">
        <a href="/notes/<?= $note->getId() ?>" class="text-decoration-none text-dark">
            <div class="card-body">
                <h1><?= htmlspecialchars($note->getContent()) ?></h1>
                <p class="colorstr">Цвет: <?= $note->getColor() ?></p>
                <p class="datechangedstr">Дата изменения: <?= $note->getDateChanged() ?></p>
                <br>
                <div class="d-flex justify-content-between">
                    <form method="POST" action="/notes/delete/<?= $note->getId() ?>" class="forms">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    <a href="/notes/edit/<?= $note->getId() ?>" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
</div>
