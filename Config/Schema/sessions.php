<?php
/**
 * This is Sessions Schema file
 *
 * Use it to configure database for Sessions
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
 * Using the Schema command line utility
 * cake schema run create Sessions
 */
class SessionsSchema extends CakeSchema
{

    public $name = 'Sessions';

    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

    public $cake_sessions = array(
        'id' => array('type' => 'string', 'null' => false, 'key' => 'primary'),
        'data' => array('type' => 'text', 'null' => true, 'default' => null),
        'expires' => array('type' => 'integer', 'null' => true, 'default' => null),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
}
