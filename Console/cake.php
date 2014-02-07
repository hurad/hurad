#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
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

if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('DS', DIRECTORY_SEPARATOR);
    define('CAKE_CORE_INCLUDE_PATH', __DIR__ . '/../Vendor/cakephp/cakephp/lib');
    define('CAKEPHP_SHELL', true);
    if (!defined('CORE_PATH')) {
        define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
    }
}
$ds = DIRECTORY_SEPARATOR;
$dispatcher = CAKE_CORE_INCLUDE_PATH . $ds . 'Cake' . $ds . 'Console' . $ds . 'ShellDispatcher.php';

if (function_exists('ini_set')) {
    $root = dirname(dirname(dirname(__FILE__)));

    // the following line differs from its sibling
    // /lib/Cake/Console/Templates/skel/Console/cake.php
    ini_set('include_path', $root . $ds . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
}

if (!include($dispatcher)) {
    trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($paths, $path, $dispatcher, $root, $ds);

return ShellDispatcher::run($argv);