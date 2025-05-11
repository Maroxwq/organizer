<?php
/**
 * @var Org\Model\Note $note
 * @var bool $isEdit
 */
$this->setGlobalVar('title', 'Organizer - ' . ($isEdit ? 'Edit' : 'Add') . ' Note');
$actionUrl = $isEdit ? $this->url('notes/edit', ['id' => $note->getId()]) : $this->url('notes/add');
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <h2 class="text-center mb-4"><?= $isEdit ? 'Edit' : 'Add' ?></h2>

        <form method="POST" action="<?= $actionUrl ?>">
            <?php $contentError = $note->getError('content'); ?>
            <div class="form-floating mb-3">
                <?php if ($isEdit): ?>
                    <textarea class="form-control <?= $contentError ? 'is-invalid' : '' ?>" id="content" name="content" placeholder="Your text" style="height: 100px;"><?= htmlspecialchars($note->getContent()) ?></textarea>
                <?php else: ?>
                    <input type="text" class="form-control <?= $contentError ? 'is-invalid' : '' ?>" id="content" name="content" value="<?= htmlspecialchars($note->getContent()) ?>" placeholder="Your text">
                <?php endif; ?>
                <label for="content">Content</label>
                <?php if ($contentError): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($contentError) ?></div>
                <?php endif; ?>
            </div>

            <?php $colorError = $note->getError('color'); ?>
            <div class="form-floating mb-3">
                <input type="color" class="form-control <?= $colorError ? 'is-invalid' : '' ?>" id="color" name="color" value="<?= htmlspecialchars($note->getColor()) ?>" style="height: 58px;">
                <label for="color">Color</label>
                <?php if ($colorError): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($colorError) ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Save</button>
        </form>
    </div>
</div>
