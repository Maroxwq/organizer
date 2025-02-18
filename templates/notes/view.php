<?php declare(strict_types = 1);
/** @var Org\Model\Note $note */
?>

<div class="note w-50 card m-3 shadow rounded myowncard mx-auto" style="background-color: <?= $note->getColor() ?>;">
    <div class="card-body">
        <h1><?= $note->getContent() ?></h1>
        <p>Цвет: <?= $note->getColor() ?></p>
        <p>Дата изменения: <?= $note->getDateChanged() ?></p> <br>
        <div class="d-flex justify-content-between">
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
</div>

