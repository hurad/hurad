<?php

HuradNavigation::addMenu('dashboard', __d('hurad', 'Dashboard'), null, 'index', array('class' => 'icon-home'));
HuradNavigation::addSubMenu('dashboard', 'admin_home', __d('hurad', 'Home'), '/admin', 'index');

HuradNavigation::addMenu('posts', __d('hurad', 'Posts'), '#', 'manage_posts', array('class' => 'icon-pencil'));
HuradNavigation::addSubMenu(
    'posts',
    'all_posts',
    __d('hurad', 'Posts'),
    array('plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'index'),
    'manage_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'add_new_post',
    __d('hurad', 'Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'posts', 'action' => 'add'),
    'publish_posts'
);
HuradNavigation::addSubMenu(
    'posts',
    'categories',
    __d('hurad', 'Categories'),
    array('plugin' => null, 'admin' => true, 'controller' => 'categories', 'action' => 'index'),
    'manage_categories'
);
HuradNavigation::addSubMenu(
    'posts',
    'tags',
    __d('hurad', 'Post Tags'),
    array('plugin' => null, 'admin' => true, 'controller' => 'tags', 'action' => 'index'),
    'manage_tags'
);

HuradNavigation::addMenu('links', __d('hurad', 'Links'), '#', 'manage_links', array('class' => 'icon-globe'));
HuradNavigation::addSubMenu(
    'links',
    'all_links',
    __d('hurad', 'Links'),
    array('plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'index'),
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'add_new_link',
    __d('hurad', 'Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'links', 'action' => 'add'),
    'manage_links'
);
HuradNavigation::addSubMenu(
    'links',
    'link_categories',
    __d('hurad', 'Link Categories'),
    array('plugin' => null, 'admin' => true, 'controller' => 'linkcats', 'action' => 'index'),
    'manage_links'
);

HuradNavigation::addMenu('pages', __d('hurad', 'Pages'), '#', 'manage_pages', array('class' => 'icon-file'));
HuradNavigation::addSubMenu(
    'pages',
    'all_pages',
    __d('hurad', 'All Pages'),
    array('plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'index'),
    'manage_pages'
);
HuradNavigation::addSubMenu(
    'pages',
    'add_new_page',
    __d('hurad', 'Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'pages', 'action' => 'add'),
    'publish_pages'
);

HuradNavigation::addMenu('comments', __d('hurad', 'Comments'), '#', 'manage_comments', array('class' => 'icon-comment'));
HuradNavigation::addSubMenu(
    'comments',
    'all_comments',
    __d('hurad', 'All Comments'),
    array('plugin' => null, 'admin' => true, 'controller' => 'comments', 'action' => 'index'),
    'manage_comments'
);

HuradNavigation::addMenu('appearance', __d('hurad', 'Appearance'), '#', 'manage_themes', array('class' => 'icon-asterisk'));
HuradNavigation::addSubMenu(
    'appearance',
    'themes',
    __d('hurad', 'Themes'),
    array('plugin' => null, 'admin' => true, 'controller' => 'themes', 'action' => 'index'),
    'switch_themes'
);
HuradNavigation::addSubMenu(
    'appearance',
    'widgets',
    __d('hurad', 'Widgets'),
    array('plugin' => null, 'admin' => true, 'controller' => 'widgets', 'action' => 'index'),
    'manage_widgets'
);
HuradNavigation::addSubMenu(
    'appearance',
    'all_menus',
    __d('hurad', 'All Menus'),
    array('plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'index'),
    'manage_menus'
);
HuradNavigation::addSubMenu(
    'appearance',
    'add_new_menu',
    __d('hurad', 'Add Menu'),
    array('plugin' => null, 'admin' => true, 'controller' => 'menus', 'action' => 'add'),
    'manage_menus'
);

HuradNavigation::addMenu('plugins', __d('hurad', 'Plugins'), '#', 'manage_plugins', array('class' => 'icon-asterisk'));
HuradNavigation::addSubMenu(
    'plugins',
    'all_plugins',
    __d('hurad', 'Plugins'),
    array('plugin' => null, 'admin' => true, 'controller' => 'plugins', 'action' => 'index'),
    'activate_plugins'
);

HuradNavigation::addMenu('users', __d('hurad', 'Users'), '#', 'manage_users', array('class' => 'icon-user'));
HuradNavigation::addSubMenu(
    'users',
    'all_users',
    __d('hurad', 'All Users'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'index'),
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'add_new_user',
    __d('hurad', 'Add New'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'add'),
    'edit_users'
);
HuradNavigation::addSubMenu(
    'users',
    'profile',
    __d('hurad', 'Edit Profile'),
    array('plugin' => null, 'admin' => true, 'controller' => 'users', 'action' => 'profile', $current_user['id']),
    'read'
);

HuradNavigation::addMenu('options', __d('hurad', 'Options'), '#', 'manage_options', array('class' => 'icon-user'));
HuradNavigation::addSubMenu(
    'options',
    'general',
    __d('hurad', 'General'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'general'),
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'comment',
    __d('hurad', 'Comment'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'comment'),
    'manage_options'
);
HuradNavigation::addSubMenu(
    'options',
    'permalink',
    __d('hurad', 'Permalinks'),
    array('plugin' => null, 'admin' => true, 'controller' => 'options', 'action' => 'prefix', 'permalink'),
    'manage_options'
);

echo $this->AdminLayout->adminMenus(Configure::read('Hurad.menus'));