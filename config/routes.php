<?php declare(strict_types=1);

return [
    '/about' => 'about/index',
    '/notes' => 'notes/index',
    '/notes/add' => 'notes/add',
    '/notes/edit/:id' => 'notes/edit',
    '/notes/delete/:id' => 'notes/delete',
    '/notes/:id' => 'notes/viewNote',
    '/notes/:id/:order' => 'notes/viewNote',
    '/draft' => 'draft/index',
    '/posts' => 'posts/index',
    '/posts/add' => 'posts/add',
    '/posts/edit/:id' => 'posts/edit',
    '/posts/delete/:id' => 'posts/delete',
    '/posts/:id' => 'posts/viewPost',
];
