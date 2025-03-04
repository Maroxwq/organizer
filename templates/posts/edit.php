<?php
/** @var \Org\Model\Post $post */
/** @var array $errors */
?>
<div class="container my-4">
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            Редактировать пост
        </div>
        <div class="card-body">
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="/posts/edit/<?= $post->getId() ?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($post->getTitle()) ?>">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Содержимое</label>
                    <textarea name="content" id="content" class="form-control" rows="5"><?= htmlspecialchars($post->getContent()) ?></textarea>
                </div>
                <button type="submit" class="btn btn-success">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>
