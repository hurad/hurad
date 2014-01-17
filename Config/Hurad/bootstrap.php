<?php
/**
 * This file is included in app/Config/bootstrap.php file
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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

Configure::write('Hurad.version', "0.1.0-alpha.6");

/**
 * Load Options
 */
App::uses('ClassRegistry', 'Utility');

$options = Cache::read('Hurad.Options');

if ($options === false) {
    $options = ClassRegistry::init('Option')->find(
        'all',
        array(
            'fields' => array(
                'Option.name',
                'Option.value',
            )
        )
    );

    $_options = [];
    foreach ($options AS $option) {
        $_options[$option['Option']['name']] = $option['Option']['value'];
        Configure::write($option['Option']['name'], $option['Option']['value']);
    }

    //Write all options in "Options" key
    Configure::write('Hurad.Options', $_options);
    Cache::write('Hurad.Options', $options);
} else {
    foreach ($options AS $option) {
        $_options[$option['Option']['name']] = $option['Option']['value'];
        Configure::write($option['Option']['name'], $option['Option']['value']);
    }
}

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
App::uses('HuradMetaBox', 'Lib');

/**
 * Include default capabilities
 */
config('Hurad/default_capabilities');

/**
 * Include default navigation
 */
config('Hurad/default_navigation');

/**
 * Load all active plugins
 */
HuradPlugin::loadAll(['Utils']);

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