<?php

/**
 * Default Hurad routes.
 */
Router::parseExtensions('json', 'rss');

/**
 * Users
 */
Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'admin' => FALSE));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => FALSE));
Router::connect('/register', array('controller' => 'users', 'action' => 'register', 'admin' => FALSE));
Router::connect('/admin', array('controller' => 'users', 'action' => 'dashboard', 'admin' => TRUE));

/**
 * Posts
 */
Router::connect('/', array('controller' => 'posts', 'action' => 'index', 'admin' => FALSE));

/**
 * Posts permalink
 */
if (Configure::read('Permalink.common') == 'default') {
    Router::connect('/p/:id', array('controller' => 'posts', 'action' => 'viewByid'), array('pass' => array('id')));
} elseif (Configure::read('Permalink.common') == 'day_name') {
    Router::connect(
            '/:year/:month/:day/:slug', array('controller' => 'posts', 'action' => 'view'), array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'day' => '0[1-9]|[12][0-9]|3[01]',
        'pass' => array('slug')
            )
    );
} elseif (Configure::read('Permalink.common') == 'month_name') {
    Router::connect(
            '/:year/:month/:slug', array('controller' => 'posts', 'action' => 'view'), array(
        'year' => '[12][0-9]{3}',
        'month' => '0[1-9]|1[012]',
        'pass' => array('slug')
            )
    );
} else {
    Router::connect('/:slug', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('slug')));
}

/**
 * Pages
 */
Router::connect('/pages', array('controller' => 'pages', 'action' => 'index', 'admin' => FALSE));

/**
 * Pages permalink
 */
if (Configure::read('Permalink.common') == 'default') {
    Router::connect('/page/:id', array('controller' => 'pages', 'action' => 'viewByid'), array('pass' => array('id')));
} else {
    Router::connect('/page/:slug', array('controller' => 'pages', 'action' => 'view'), array('pass' => array('slug')));
}
/**
 * Comments
 */
Router::connect('/comments/reply/:post_id/:comment_id', array('controller' => 'comment', 'action' => 'reply'), array('pass' => array('post_id', 'id'), 'post_id' => '[0-9]+', 'id' => '[0-9]+'));