<?php

App::import('Lib', 'HuradHook');
$HuradHook = new HuradHook();
Configure::write('HuradHook.obj', $HuradHook);
require APPLIBS . 'filters.php';

App::uses('Functions', 'Lib');
App::uses('Formatting', 'Lib');
App::uses('HrNav', 'Lib');
App::uses('HuradPlugin', 'Lib');
App::uses('Hurad', 'Lib');
App::uses('HuradWidget', 'Lib');

/**
 * Load all active plugins
 */
HuradPlugin::loadAll();

/**
 * Include current theme bootstrap file.
 */
$theme_bootstrap = APP . 'View' . DS . 'Themed' . DS . Configure::read('template') . DS . 'Config' . DS . 'bootstrap.php';
if (is_file($theme_bootstrap) && file_exists($theme_bootstrap)) {
    include $theme_bootstrap;
}