<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */

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
    '/comments/reply/:post_id/:parent_id',
    ['controller' => 'comments', 'action' => 'reply'],
    ['post_id' => '[0-9]+', 'parent_id' => '[0-9]+']
);
