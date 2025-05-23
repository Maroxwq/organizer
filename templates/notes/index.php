<?php
/**
 * @var Org\Model\Note[] $notes
 * @var string|null $message
 */
$this->setGlobalVar('title', 'Organizer - Notes');
?>
<div class="text-center">
    <a href="<?= $this->url('notes/add')?>" class="btn btn-primary btn-lg mb-3 mt-4">Add note</a>
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
                <p class="datechangedstr">Change date: <?= $note->getDateChanged() ?></p>
                <br>
                <div class="d-flex justify-content-between">
                    <a href="<?= $this->url('notes/delete', ['id' => $note->getId()]) ?>" class="btn btn-danger"><i class="bi bi-x-square-fill"></i></a>
                    <a href="<?= $this->url('notes/edit', ['id' => $note->getId()]) ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
</div>
