<?php
/**
 * Default navigation
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

HuradNavigation::addMenu(
    'dashboard',
    __d('hurad', 'Dashboard'),
    null,
    'index',
    ['class' => 'glyphicon glyphicon-home']
);
HuradNavigation::addSubMenu('dashboard', 'admin_home', __d('hurad', 'Home'), '/admin', 'index');

HuradNavigation::addMenu(
    'posts',
    __d('hurad', 'Posts'),
    '#',
    'manage_posts',
    ['class' => 'glyphicon glyphicon-pencil']
);
HuradNavigation::addSubMenu(
    'posts',
    'all_posts',
    __d('hurad', 'Posts'),
    ['plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'index'],
    'manage_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'add_new_post',
    __d('hurad', 'Add New'),
    ['plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'add'],
    'publish_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'categories',
    __d('hurad', 'Categories'),
    ['plugin' => null, 'admin' => true, 'controller' => 'categories', 'action' => 'index'],
    'manage_categories'
);
HuradNavigation::addSubMenu(
    'posts',
    'tags',
    __d('hurad', 'Post Tags'),
    ['plugin' => null, 'admin' => true, 'controller' => 'tags', 'action' => 'index'],
    'manage_tags'
);

HuradNavigation::addMenu(
    'media',
    __d('hurad', 'Media'),
    '#',
    'manage_media',
    ['class' => 'glyphicon glyphicon-cloud']
);
HuradNavigation::addSubMenu(
    'media',
    'all_media',
    __d('hurad', 'Media Library'),
    ['plugin' => null, 'admin' => true, 'controller' => 'media', 'action' => 'index'],
    'manage_links'
);
HuradNavigation::addSubMenu(
    'media',
    'add_new_media',
    __d('hurad', 'Add New'),
    ['plugin' => null, 'admin' => true, 'controller' => 'media', 'action' => 'add'],
    'manage_links'
);

HuradNavigation::addMenu(
    'links',
    __d('hurad', 'Links'),
    '#',
    'manage_links',
    ['class' => 'glyphicon glyphicon-link']
);
HuradNavigation::addSubMenu(
    'links',
    'all_links',
    __d('hurad', 'Links'),
    ['plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'index'],
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'add_new_link',
    __d('hurad', 'Add New'),
    ['plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'add'],
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'link_categories',
    __d('hurad', 'Link Categories'),
    ['plugin' => null, 'admin' => true, 'controller' => 'linkcats', 'action' => 'index'],
    'manage_links'
);

HuradNavigation::addMenu(
    'pages',
    __d('hurad', 'Pages'),
    '#',
    'manage_pages',
    ['class' => 'glyphicon glyphicon-file']
);
HuradNavigation::addSubMenu(
    'pages',
    'all_pages',
    __d('hurad', 'All Pages'),
    ['plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'index'],
    'manage_pages'
);
HuradNavigation::addSubMenu(
    'pages',
    'add_new_page',
    __d('hurad', 'Add New'),
    ['plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'add'],
    'publish_pages'
);

HuradNavigation::addMenu(
    'comments',
    __d('hurad', 'Comments'),
    '#',
    'manage_comments',
    ['class' => 'glyphicon glyphicon-comment']
);
HuradNavigation::addSubMenu(
    'comments',
    'all_comments',
    __d('hurad', 'All Comments'),
    ['plugin' => null, 'admin' => true, 'controller' => 'comments', 'action' => 'index'],
    'manage_comments'
);

HuradNavigation::addMenu(
    'appearance',
    __d('hurad', 'Appearance'),
    '#',
    'manage_themes',
    ['class' => 'glyphicon glyphicon-asterisk']
);
HuradNavigation::addSubMenu(
    'appearance',
    'themes',
    __d('hurad', 'Themes'),
    ['plugin' => null, 'admin' => true, 'controller' => 'themes', 'action' => 'index'],
    'switch_themes'
);
HuradNavigation::addSubMenu(
    'appearance',
    'widgets',
    __d('hurad', 'Widgets'),
    ['plugin' => null, 'admin' => true, 'controller' => 'widgets', 'action' => 'index'],
    'manage_widgets'
);
HuradNavigation::addSubMenu(
    'appearance',
    'all_menus',
    __d('hurad', 'All Menus'),
    ['plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'index'],
    'manage_menus'
);
HuradNavigation::addSubMenu(
    'appearance',
    'add_new_menu',
    __d('hurad', 'Add Menu'),
    ['plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'add'],
    'manage_menus'
);

HuradNavigation::addMenu(
    'plugins',
    __d('hurad', 'Plugins'),
    '#',
    'manage_plugins',
    ['class' => 'glyphicon glyphicon-pushpin']
);
HuradNavigation::addSubMenu(
    'plugins',
    'all_plugins',
    __d('hurad', 'Plugins'),
    ['plugin' => null, 'admin' => true, 'controller' => 'plugins', 'action' => 'index'],
    'activate_plugins'
);

HuradNavigation::addMenu(
    'users',
    __d('hurad', 'Users'),
    '#',
    'manage_users',
    ['class' => 'glyphicon glyphicon-user']
);
HuradNavigation::addSubMenu(
    'users',
    'all_users',
    __d('hurad', 'All Users'),
    ['plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'index'],
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'add_new_user',
    __d('hurad', 'Add New'),
    ['plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'add'],
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'profile',
    __d('hurad', 'Edit Profile'),
    ['plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'profile'],
    'read'
);

HuradNavigation::addMenu(
    'options',
    __d('hurad', 'Options'),
    '#',
    'manage_options',
    ['class' => 'glyphicon glyphicon-wrench']
);
HuradNavigation::addSubMenu(
    'options',
    'general',
    __d('hurad', 'General'),
    ['plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'general'],
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'comment',
    __d('hurad', 'Comment'),
    ['plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'comment'],
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'permalink',
    __d('hurad', 'Permalinks'),
    ['plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'permalink'],
    'manage_options'
);
