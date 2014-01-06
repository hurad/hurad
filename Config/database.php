<?php
/**
 * In this file you set up your database connection details.
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

/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 */
class DATABASE_CONFIG
{

    public $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'database_username',
        'password' => 'database_password',
        'database' => 'hurad',
        'prefix' => 'hr_',
        'encoding' => 'utf8'
    );

    public $test = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'database_username',
        'password' => 'database_password',
        'database' => 'hurad_test',
        'prefix' => 'hr_',
        'encoding' => 'utf8'
    );
}
