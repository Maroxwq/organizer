<?php
use Arc\View\View;
/** @var View $this */
/** @var \Org\Model\Post $post */

$this->extends('layout');
?>

<div class="container mt-4 bg-light p-3">
    <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
    <p class="text-muted">Автор: <?= htmlspecialchars($post->getAuthorName()) ?> | Создан: <?= $post->getCreatedAt() ?> | Обновлен: <?= $post->getUpdatedAt() ?></p>
    <div>
        <?= nl2br(htmlspecialchars($post->getContent())) ?>
    </div>
    <div class="mt-3">
        <a href="/posts/edit/<?= $post->getId() ?>" class="btn btn-primary">Редактировать</a>
        <form method="POST" action="/posts/delete/<?= $post->getId() ?>" class="d-inline">
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
        <a href="/posts" class="btn btn-secondary">Назад к списку</a>
    </div>
</div>
