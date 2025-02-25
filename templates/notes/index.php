<?php

use Org\Core\View;

/** @var View $this */
$this->extends('layout');
?>

<div class="text-center">
    <a href="/notes/add" class="btn btn-primary btn-lg mb-3 mt-4">Добавить заметку</a>
</div>
<div class="container d-flex flex-wrap" style="justify-content: space-around;">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded myowncard" style="background-color: <?= $note->getColor() ?>;">
    <a href="/notes/<?= $note->getId() ?>" class="text-decoration-none text-dark">
        <div class="card-body">
            <h1><?= htmlspecialchars($note->getContent()) ?></h1>
            <p class="colorstr">Цвет: <?= $note->getColor() ?></p>
            <p class="datechangedstr">Дата изменения: <?= $note->getDateChanged() ?></p> <br>
            <div class="d-flex justify-content-between">
            <form method="POST" action="/notes/delete" class="forms">
                <input type="hidden" name="id" value="<?= $note->getId() ?>">
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
            <a href="/notes/edit/<?= $note->getId() ?>" class="btn btn-primary">Изменить</a>
            </div>
        </div>
    </a>
    </div>
<?php } ?>
</div>