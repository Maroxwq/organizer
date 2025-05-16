<?php
/** @var Org\Model\Note $note */
/** @var bool $isEdit */
$this->setGlobalVar('title', 'Organizer – ' . ($isEdit ? 'Edit' : 'Add') . ' Note');
$actionUrl = $isEdit ? $this->url('notes/edit', ['id' => $note->getId()]) : $this->url('notes/add');
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <h2 class="text-center mb-4"><?= $isEdit ? 'Edit' : 'Add' ?> Note</h2>
        <form method="POST" action="<?= $actionUrl ?>">
            <div class="form-floating mb-3">
                <?= $isEdit ? '<textarea class="form-control' . ($note->hasError('content') ? ' is-invalid' : '') . '" id="content" name="content" placeholder="Your text" style="height: 100px;">'
                . htmlspecialchars($note->getContent()) . '</textarea>' 
                : '<input type="text" class="form-control' . ($note->hasError('content') ? ' is-invalid' : '') . '" id="content" name="content" value="'
                . htmlspecialchars($note->getContent()) . '" placeholder="Your text">' ?>
                <label for="content">Content</label>
                <?php if ($note->hasError('content')): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($note->getError('content')) ?></div>
                <?php endif; ?>
            </div>
            <div class="form-floating mb-3">
                <input type="color" class="form-control<?= $note->hasError('color') ? ' is-invalid' : '' ?>" id="color" name="color" value="<?= htmlspecialchars($note->getColor()) ?>" style="height: 58px;">
                <label for="color">Color</label>
                <?php if ($note->hasError('color')): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($note->getError('color')) ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save</button>
        </form>
    </div>
</div>
