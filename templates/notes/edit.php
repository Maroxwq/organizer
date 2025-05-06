<?php
/**
 * @var Org\Model\Note $note
 * @var array<string,string> $errors
 */
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <h2 class="text-center mb-4">Edit</h2>
        <form method="POST" action="/notes/edit/<?= $note->getId() ?>">
            <?php $contentError = $note->getError('content'); ?>
            <div class="form-floating mb-3">
                <textarea class="form-control <?= $contentError ? 'is-invalid' : '' ?>" id="content" name="content" placeholder="Введите текст" style="height: 100px;"><?= htmlspecialchars($note->getContent()) ?></textarea>
                <label for="content">Content</label>
                <?php if ($contentError): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($contentError) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php $colorError = $note->getError('color'); ?>
            <div class="form-floating mb-3">
                <input type="color" class="form-control <?= $colorError ? 'is-invalid' : '' ?>" id="color" name="color" value="<?= htmlspecialchars($note->getColor()) ?>" style="height: 58px;">
                <label for="color">Color</label>
                <?php if ($colorError): ?>
                    <div class="invalid-feedback">
                        <?= htmlspecialchars($colorError) ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary w-100">Save</button>
        </form>
    </div>
</div>
