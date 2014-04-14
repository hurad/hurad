<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
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

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *                'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *                'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *                 array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *                array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write(
    'Dispatcher.filters',
    array(
        'AssetDispatcher',
        'CacheDispatcher'
    )
);

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config(
    'debug',
    array(
        'engine' => 'File',
        'types' => array('notice', 'info', 'debug'),
        'file' => 'debug',
    )
);
CakeLog::config(
    'error',
    array(
        'engine' => 'File',
        'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
        'file' => 'error',
    )
);

/**
 * Define App/Config/ dir
 */
define('CONFIG', APP . 'Config' . DS);

/**
 * Define App/Config/Schema/ dir
 */
define('SCHEMA', APP . 'Config' . DS . 'Schema' . DS);

/**
 * Define App/Config/Hurad/ dir
 */
define('HURAD_CONFIG', CONFIG . 'Hurad' . DS);

Configure::write('Installed', isInstalled());

if (file_exists(APP . '/Vendor/autoload.php')) {
    // Load composer autoload.
    require APP . '/Vendor/autoload.php';

// Remove and re-prepend CakePHP's autoloader as composer thinks it is the most important.
// See https://github.com/composer/composer/commit/c80cb76b9b5082ecc3e5b53b1050f76bb27b127b
    spl_autoload_unregister(array('App', 'load'));
    spl_autoload_register(array('App', 'load'), true, true);
}

if (Configure::read('Installed')) {
    config('Hurad/bootstrap');
}

function isInstalled()
{
    if (isConnected()) {
        App::uses('ConnectionManager', 'Model');
        $dataSource = ConnectionManager::getDataSource('default');

        $baseTables = [
            'categories' => $dataSource->config['prefix'] . 'categories',
            'categories_posts' => $dataSource->config['prefix'] . 'categories_posts',
            'comments' => $dataSource->config['prefix'] . 'comments',
            'links' => $dataSource->config['prefix'] . 'links',
            'menus' => $dataSource->config['prefix'] . 'menus',
            'options' => $dataSource->config['prefix'] . 'options',
            'post_meta' => $dataSource->config['prefix'] . 'post_meta',
            'posts' => $dataSource->config['prefix'] . 'posts',
            'posts_tags' => $dataSource->config['prefix'] . 'posts_tags',
            'tags' => $dataSource->config['prefix'] . 'tags',
            'user_meta' => $dataSource->config['prefix'] . 'user_meta',
            'users' => $dataSource->config['prefix'] . 'users',
        ];

        $installed = [];
        App::uses('ClassRegistry', 'Utility');
        foreach ($baseTables as $table => $tablePrefix) {
            if (in_array($tablePrefix, $dataSource->listSources()) && count($dataSource->describe($table)) > 0 && count(
                    ClassRegistry::init('Option')->getOptions()
                ) > 0
            ) {
                $installed[$table] = true;
            } else {
                $installed[$table] = false;
            }
        }
    } else {
        $installed['database.php'] = false;
    }

    return !in_array(false, $installed);
}

function isConnected()
{
    if (file_exists(CONFIG . 'database.php')) {
        try {
            App::uses('ConnectionManager', 'Model');
            ConnectionManager::getDataSource('default');
        } catch (Exception $e) {
            return false;
        }
    } else {
        return false;
    }

    return true;
}
