<?php

HrNav::add('dashboard', array(
    'title' => __('Dashboard'),
    'url' => '#',
    'img' => 'home.png',
    'weight' => 1,
    'child' => array(
        'home' => array(
            'title' => __('Home'),
            'url' => '/admin',
            'weight' => 1,
        ),
    ),
));
HrNav::add('posts', array(
    'title' => __('Posts'),
    'url' => '#',
    'img' => 'pin.png',
    'weight' => 2,
    'child' => array(
        'posts' => array(
            'title' => __('Posts'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'posts', 'action' => 'index'),
            'weight' => 1,
        ),
        'add_new' => array(
            'title' => __('Add New'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'posts', 'action' => 'add'),
            'weight' => 2,
        ),
        'categories' => array(
            'title' => __('Categories'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'categories', 'action' => 'index'),
            'weight' => 3,
        ),
        'tags' => array(
            'title' => __('Tags'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'tags', 'action' => 'index'),
            'weight' => 4,
        ),
    ),
));
HrNav::add('links', array(
    'title' => __('Links'),
    'url' => '#',
    'img' => 'chain.png',
    'weight' => 3,
    'child' => array(
        'all_links' => array(
            'title' => __('All Links'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'links', 'action' => 'index'),
            'weight' => 1,
        ),
        'add_link' => array(
            'title' => __('Add Link'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'links', 'action' => 'add'),
            'weight' => 2,
        ),
        'link_categories' => array(
            'title' => __('Link Categories'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'linkcats', 'action' => 'index'),
            'weight' => 3,
        ),
        'add_link_categories' => array(
            'title' => __('Add Link Categories'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'linkcats', 'action' => 'add'),
            'weight' => 4,
        ),
    ),
));
HrNav::add('pages', array(
    'title' => __('Pages'),
    'url' => '#',
    'img' => 'report-paper.png',
    'weight' => 4,
    'child' => array(
        'all_pages' => array(
            'title' => __('All Pages'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'pages', 'action' => 'index'),
            'weight' => 1,
        ),
        'add_new' => array(
            'title' => __('Add New'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'pages', 'action' => 'add'),
            'weight' => 2,
        ),
    ),
));
HrNav::add('comments', array(
    'title' => __('Comments'),
    'url' => '#',
    'img' => 'sticky-notes-pin.png',
    'weight' => 5,
    'child' => array(
        'all_comments' => array(
            'title' => __('All Comments'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'comments', 'action' => 'index'),
            'weight' => 1,
        ),
    ),
));
HrNav::add('appearance', array(
    'title' => __('Appearance'),
    'url' => '#',
    'img' => 'application-blog.png',
    'weight' => 6,
    'child' => array(
        'themes' => array(
            'title' => __('Themes'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'themes', 'action' => 'index'),
            'weight' => 1,
        ),
        'all_menus' => array(
            'title' => __('All Menus'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'menus', 'action' => 'index'),
            'weight' => 2,
        ),
        'add_menu' => array(
            'title' => __('Add Menu'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'menus', 'action' => 'add'),
            'weight' => 3,
        ),
    ),
));
HrNav::add('plugins', array(
    'title' => __('Plugins'),
    'url' => '#',
    'img' => 'plug.png',
    'weight' => 7,
    'child' => array(
        'plugins' => array(
            'title' => __('Plugins'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'plugins', 'action' => 'index'),
            'weight' => 1,
        ),
    ),
));
HrNav::add('users', array(
    'title' => __('Users'),
    'url' => '#',
    'img' => 'users.png',
    'weight' => 8,
    'child' => array(
        'all_users' => array(
            'title' => __('All Users'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'users', 'action' => 'index'),
            'weight' => 1,
        ),
        'add_new' => array(
            'title' => __('Add New'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'users', 'action' => 'add'),
            'weight' => 2,
        ),
    ),
));
HrNav::add('options', array(
    'title' => __('Options'),
    'url' => '#',
    'img' => 'toolbox.png',
    'weight' => 9,
    'child' => array(
        'general' => array(
            'title' => __('General'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'options', 'action' => 'prefix', 'general'),
            'weight' => 1,
        ),
        'comment' => array(
            'title' => __('Comment'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'options', 'action' => 'prefix', 'comment'),
            'weight' => 2,
        ),
        'permalink' => array(
            'title' => __('Permalinks'),
            'url' => array('plugin' => NULL, 'admin' => TRUE, 'controller' => 'options', 'action' => 'prefix', 'permalink'),
            'weight' => 3,
        ),
    ),
));
echo $this->AdminLayout->adminMenus(HrNav::items());