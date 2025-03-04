<?php
use Arc\View\View;
/** @var View $this */
/** @var \Org\Model\Post[] $posts */

$this->extends('layout');
?>

<div class="text-center">
    <a href="/posts/add" class="btn btn-primary btn-lg mb-3 mt-4">Создать пост</a>
</div>
<div class="container">
    <?php foreach ($posts as $post) { ?>
        <div class="card mb-3 shadow-sm post-card" style="background-color: #f5f5f5; border-radius: 8px;">
            <a href="/posts/<?= $post->getId() ?>" class="text-decoration-none text-dark">
                <div class="card-body">
                    <h2><?= htmlspecialchars($post->getTitle()) ?></h2>
                    <p><?= htmlspecialchars($post->getContent()) ?></p>
                </div>
            </a>
            <div class="card-footer d-flex justify-content-between">
                <p class="mb-0">
                    Автор:
                    <a href="#" class="text-decoration-none text-dark">
                        <?= htmlspecialchars($post->getAuthorName()) ?>
                    </a>
                </p>
                <div>
                    <form method="POST" action="/posts/delete/<?= $post->getId() ?>" class="d-inline">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    <a href="/posts/edit/<?= $post->getId() ?>" class="btn btn-primary">Редактировать</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
