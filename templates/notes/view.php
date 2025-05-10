<?php declare(strict_types = 1);
/** @var Org\Model\Note $note */
?>

<div class="note w-50 card m-3 shadow rounded myowncard mx-auto" style="background-color: <?= $note->getColor() ?>;">
    <div class="card-body">
        <h1><?= htmlspecialchars($note->getContent()) ?></h1>
        <p>Цвет: <?= $note->getColor() ?></p>
        <p>Дата изменения: <?= $note->getDateChanged() ?></p> <br>
        <div class="d-flex justify-content-between">
        <a href="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>" class="btn btn-danger"><i class="bi bi-x-square-fill"></i></a>
        <a href="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
        </div>
    </div>
</div>

