<?php

App::uses('Akismet', 'Akismet.Lib');

HuradNavigation::addSubMenu(
    'options',
    'akismet',
    __d('hurad', 'Akismet Configuration'),
    ['admin' => true, 'plugin' => 'akismet', 'controller' => 'akismet'],
    'manage_options'
);

Hurad::applyBehavior('Comment', 'Akismet.Akismet');