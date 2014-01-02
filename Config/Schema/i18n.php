<?php
/**
 * This is i18n Schema file
 *
 * Use it to configure database for i18n
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
 * cake schema run create i18n
 */
class i18nSchema extends CakeSchema
{

    public $name = 'i18n';

    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

    public $i18n = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'locale' => array('type' => 'string', 'null' => false, 'length' => 6, 'key' => 'index'),
        'model' => array('type' => 'string', 'null' => false, 'key' => 'index'),
        'foreign_key' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
        'field' => array('type' => 'string', 'null' => false, 'key' => 'index'),
        'content' => array('type' => 'text', 'null' => true, 'default' => null),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'locale' => array('column' => 'locale', 'unique' => 0),
            'model' => array('column' => 'model', 'unique' => 0),
            'row_id' => array('column' => 'foreign_key', 'unique' => 0),
            'field' => array('column' => 'field', 'unique' => 0)
        )
    );
}
