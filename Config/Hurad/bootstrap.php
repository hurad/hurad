<?php

Configure::write('Hurad.version', "0.1.0-alpha.3");

/**
 * Load Options
 */
App::uses('ClassRegistry', 'Utility');

$options = ClassRegistry::init('Option')->find(
    'all',
    array(
        'fields' => array(
            'Option.name',
            'Option.value',
        )
    )
);
foreach ($options AS $option) {
    $_options[$option['Option']['name']] = $option['Option']['value'];
    Configure::write($option['Option']['name'], $option['Option']['value']);
}
//Write all options in "Options" key
Configure::write('Options', $_options);

/**
 * Load HuradHook Lib and include default filters
 */
App::uses('HuradHook', 'Lib');
config('Hurad/default_filters');

/**
 * Load Hurad Lib
 */
App::uses('HuradFunctions', 'Lib');
App::uses('HuradFormatting', 'Lib');
App::uses('HuradSanitize', 'Lib');
App::uses('HuradPlugin', 'Lib');
App::uses('Hurad', 'Lib');
App::uses('HuradWidget', 'Lib');
App::uses('HuradRole', 'Lib');
App::uses('HuradNavigation', 'Lib');
App::uses('HuradRowActions', 'Lib');

/**
 * Include default capabilities
 */
config('Hurad/default_capabilities');

/**
 * Load all active plugins
 */
HuradPlugin::loadAll(array('Utils'));

/**
 * Include default widgets
 */
config('Hurad/default_widgets');

/**
 * Include current theme bootstrap file.
 */
$theme_bootstrap = APP . 'View' . DS . 'Themed' . DS . Configure::read(
        'template'
    ) . DS . 'Config' . DS . 'bootstrap.php';
if (is_file($theme_bootstrap) && file_exists($theme_bootstrap)) {
    include $theme_bootstrap;
}