<?php

App::import('Lib', 'HuradHook');
$HuradHook = new HuradHook();
Configure::write('HuradHook.obj', $HuradHook);
require APPLIBS . 'filters.php';

App::uses('Functions', 'Lib');
App::uses('Formatting', 'Lib');
App::uses('HrNav', 'Lib');
App::uses('HrPlugin', 'Lib');
App::uses('Hurad', 'Lib');
/**
 * Plugins
 */
$pluginBootstraps = Configure::read('Plugin.bootstraps');
$plugins = array_filter(explode(',', $pluginBootstraps));
foreach ($plugins as $plugin) {
    $pluginName = Inflector::camelize($plugin);
    if (!file_exists(APP . 'Plugin' . DS . $pluginName)) {
        CakeLog::write(LOG_ERR, 'Plugin not found during bootstrap: ' . $pluginName);
        continue;
    }
    $bootstrapFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'bootstrap.php';
    $bootstrap = file_exists($bootstrapFile);
    $routesFile = APP . 'Plugin' . DS . $pluginName . DS . 'Config' . DS . 'routes.php';
    $routes = file_exists($routesFile);
    $option = array(
        $pluginName => array(
            'bootstrap' => $bootstrap,
            'routes' => $routes,
        )
    );
    HrPlugin::load($option);
}