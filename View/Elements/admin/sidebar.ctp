<?php

HuradNavigation::addMenu('dashboard', __('Dashboard'), null, 'index', array('class' => 'icon-home'));
HuradNavigation::addSubMenu('dashboard', 'admin_home', __('Home'), '/admin', 'index');

HuradNavigation::addMenu('posts', __('Posts'), '#', 'manage_posts', array('class' => 'icon-pencil'));
HuradNavigation::addSubMenu(
    'posts',
    'all_posts',
    __('Posts'),
    array('plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'index'),
    'manage_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'add_new_post',
    __('Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'add'),
    'publish_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'categories',
    __('Categories'),
    array('plugin' => null, 'admin' => true, 'controller' => 'categories', 'action' => 'index'),
    'manage_categories'
);
HuradNavigation::addSubMenu(
    'posts',
    'tags',
    __('Post Tags'),
    array('plugin' => null, 'admin' => true, 'controller' => 'tags', 'action' => 'index'),
    'manage_tags'
);

HuradNavigation::addMenu('links', __('Links'), '#', 'manage_links', array('class' => 'icon-globe'));
HuradNavigation::addSubMenu(
    'links',
    'all_links',
    __('Links'),
    array('plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'index'),
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'add_new_link',
    __('Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'add'),
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'link_categories',
    __('Link Categories'),
    array('plugin' => null, 'admin' => true, 'controller' => 'linkcats', 'action' => 'index'),
    'manage_links'
);

HuradNavigation::addMenu('pages', __('Pages'), '#', 'manage_pages', array('class' => 'icon-file'));
HuradNavigation::addSubMenu(
    'pages',
    'all_pages',
    __('All Pages'),
    array('plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'index'),
    'manage_pages'
);
HuradNavigation::addSubMenu(
    'pages',
    'add_new_page',
    __('Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'add'),
    'publish_pages'
);

HuradNavigation::addMenu('comments', __('Comments'), '#', 'manage_comments', array('class' => 'icon-comment'));
HuradNavigation::addSubMenu(
    'comments',
    'all_comments',
    __('All Comments'),
    array('plugin' => null, 'admin' => true, 'controller' => 'comments', 'action' => 'index'),
    'manage_comments'
);

HuradNavigation::addMenu('appearance', __('Appearance'), '#', 'manage_themes', array('class' => 'icon-asterisk'));
HuradNavigation::addSubMenu(
    'appearance',
    'themes',
    __('Themes'),
    array('plugin' => null, 'admin' => true, 'controller' => 'themes', 'action' => 'index'),
    'switch_themes'
);
HuradNavigation::addSubMenu(
    'appearance',
    'widgets',
    __('Widgets'),
    array('plugin' => null, 'admin' => true, 'controller' => 'widgets', 'action' => 'index'),
    'manage_widgets'
);
HuradNavigation::addSubMenu(
    'appearance',
    'all_menus',
    __('All Menus'),
    array('plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'index'),
    'manage_menus'
);
HuradNavigation::addSubMenu(
    'appearance',
    'add_new_menu',
    __('Add Menu'),
    array('plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'add'),
    'manage_menus'
);

HuradNavigation::addMenu('plugins', __('Plugins'), '#', 'manage_plugins', array('class' => 'icon-asterisk'));
HuradNavigation::addSubMenu(
    'plugins',
    'all_plugins',
    __('Plugins'),
    array('plugin' => null, 'admin' => true, 'controller' => 'plugins', 'action' => 'index'),
    'activate_plugins'
);

HuradNavigation::addMenu('users', __('Users'), '#', 'manage_users', array('class' => 'icon-user'));
HuradNavigation::addSubMenu(
    'users',
    'all_users',
    __('All Users'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'index'),
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'add_new_user',
    __('Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'add'),
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'profile',
    __('Edit Profile'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'profile', $current_user['id']),
    'read'
);

HuradNavigation::addMenu('options', __('Options'), '#', 'manage_options', array('class' => 'icon-user'));
HuradNavigation::addSubMenu(
    'options',
    'general',
    __('General'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'general'),
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'comment',
    __('Comment'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'comment'),
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'permalink',
    __('Permalinks'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'permalink'),
    'manage_options'
);

echo $this->AdminLayout->adminMenus(Configure::read('Hurad.menus'));