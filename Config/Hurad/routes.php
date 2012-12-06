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
Router::connect('/:slug', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('slug')));

/**
 * Pages
 */
Router::connect('/pages', array('controller' => 'posts', 'action' => 'index', 'admin' => FALSE, 'page'));
Router::connect('/admin/pages/add', array('controller' => 'posts', 'action' => 'add', 'admin' => TRUE, 'page'));

/**
 * Comments
 */
Router::connect('/comments/reply/:post_id/:comment_id', array('controller' => 'comment', 'action' => 'reply'), array('pass' => array('post_id', 'id'), 'post_id' => '[0-9]+', 'id' => '[0-9]+'));
?>
