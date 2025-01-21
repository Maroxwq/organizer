<?php

use Org\Core\View;

/** @var View $this */
$this->extends('layout');
?>

<a href="/notes/add" class="button">добавить заметку</a>
<div class="container d-flex flex-wrap">
<?php foreach ($notes as $note) { ?>
    <div class="note w-25 card m-3 shadow rounded" style="background-color: <?= htmlspecialchars($note->getColor()) ?>; ">
        <div class="card-body">
            <h1><?= $note->getContent() ?></h1>
            <p class="colorstr">цвет: <?= $note->getColor() ?></p>
            <p class="datechangedstr">дата изменения: <?= $note->getDateChanged() ?></p> <br>
            <form method="POST" action="/notes/delete" class="forms">
                <input type="hidden" name="id" value="<?= $note->getId() ?>">
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
            <form method="POST" action="/notes/edit" class="forms">
                <input type="hidden" name="id" value="<?= $note->getId() ?>">
                <button type="submit" class="btn btn-primary">Изменить</button>
            </form>
        </div>
    </div>
<?php } ?>
</div>
