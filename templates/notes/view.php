<?php declare(strict_types = 1);
/** @var Org\Model\Note $note */
$this->setGlobalVar('title', 'Organizer - Note');
?>

<div class="note w-50 card m-3 shadow rounded myowncard mx-auto" style="background-color: <?= $note->getColor() ?>;">
    <div class="card-body">
        <h1><?= htmlspecialchars($note->getContent()) ?></h1>
        <p>Color: <?= $note->getColor() ?></p>
        <p>Change date: <?= $note->getDateChanged() ?></p> <br>
        <div class="d-flex justify-content-between">
        </div>
    </div>
</div>