<?php declare(strict_types=1);

return [
    '/login' => 'auth/login',
    '/register' => 'auth/register',
    '/logout' => 'auth/logout',

    '/about' => 'about/index',

    '/notes' => 'notes/index',
    '/notes/add' => 'notes/add',
    '/notes/edit/:id' => 'notes/edit',
    '/notes/delete/:id' => 'notes/delete',
    '/notes/:id' => 'notes/viewNote',
    '/notes/:id/:order' => 'notes/viewNote',

    '/posts' => 'posts/index',
    '/posts/add' => 'posts/add',
    '/posts/edit/:id' => 'posts/edit',
    '/posts/delete/:id' => 'posts/delete',
    '/posts/:id' => 'posts/viewPost',

    '/draft' => 'draft/index',
];
