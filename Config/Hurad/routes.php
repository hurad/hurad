<?php

/**
 * Default Hurad routes.
 */
Router::parseExtensions('json', 'rss');

/**
 * Users
 */
Router::connect('/login', ['controller' => 'users', 'action' => 'login', 'admin' => false]);
Router::connect('/logout', ['controller' => 'users', 'action' => 'logout', 'admin' => false]);
Router::connect('/register', ['controller' => 'users', 'action' => 'register', 'admin' => false]);
Router::connect('/admin', ['controller' => 'users', 'action' => 'dashboard', 'admin' => true]);

/**
 * Posts
 */
Router::connect('/', ['controller' => 'posts', 'action' => 'index', 'admin' => false]);
Router::connect('/feed', ['controller' => 'posts', 'action' => 'index', 'url' => ['ext' => 'rss']]);
Router::connect('/category/*', ['controller' => 'posts', 'action' => 'indexByTaxonomy', 'admin' => false, 'category']);
Router::connect('/tag/*', ['controller' => 'posts', 'action' => 'indexByTaxonomy', 'admin' => false, 'tag']);
Router::connect('/author/*', ['controller' => 'posts', 'action' => 'indexByTaxonomy', 'admin' => false, 'author']);

/**
 * Posts permalink
 */
if (Configure::read('Permalink.common') == 'default') {
    Router::connect('/p/:id', ['controller' => 'posts', 'action' => 'viewByid'], ['pass' => ['id']]);
} elseif (Configure::read('Permalink.common') == 'day_name') {
    Router::connect(
        '/:year/:month/:day/:slug',
        ['controller' => 'posts', 'action' => 'view'],
        [
            'year' => '[12][0-9]{3}',
            'month' => '0[1-9]|1[012]',
            'day' => '0[1-9]|[12][0-9]|3[01]',
            'pass' => ['slug']
        ]
    );
} elseif (Configure::read('Permalink.common') == 'month_name') {
    Router::connect(
        '/:year/:month/:slug',
        ['controller' => 'posts', 'action' => 'view'],
        [
            'year' => '[12][0-9]{3}',
            'month' => '0[1-9]|1[012]',
            'pass' => ['slug']
        ]
    );
} else {
    Router::connect('/:slug', ['controller' => 'posts', 'action' => 'view'], ['pass' => ['slug']]);
}

/**
 * Pages
 */
Router::connect('/pages', ['controller' => 'pages', 'action' => 'index', 'admin' => false]);

/**
 * Pages permalink
 */
if (Configure::read('Permalink.common') == 'default') {
    Router::connect('/page/:id', ['controller' => 'pages', 'action' => 'viewByid'], ['pass' => ['id']]);
} else {
    Router::connect('/page/:slug', ['controller' => 'pages', 'action' => 'view'], ['pass' => ['slug']]);
}
/**
 * Comments
 */
Router::connect(
    '/comments/reply/:postID/:parentID',
    ['controller' => 'comments', 'action' => 'reply'],
    ['pass' => ['postID', 'parentID'], 'postID' => '[0-9]+', 'parentID' => '[0-9]+']
);
