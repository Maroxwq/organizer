<?php
/** @var Org\Model\Note $note */
$actionUrl = $note->isNew() ? $this->url('notes/add') : $this->url('notes/edit', ['id' => $note->getId()]);
?>

<form method="POST" action="<?= $actionUrl ?>">
    <div class="form-floating mb-3">
        <input type="text" class="form-control<?= $note->hasError('content') ? ' is-invalid' : '' ?>" id="content" name="content" value="<?= htmlspecialchars($note->getContent()) ?>" placeholder="Your text">
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

