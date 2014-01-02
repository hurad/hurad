<?php
/**
 * This is Acl Schema file
 *
 * Use it to configure database for ACL
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
 * cake schema run create DbAcl
 */
class DbAclSchema extends CakeSchema
{

    public $name = 'DbAcl';

    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

    public $acos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'model' => array('type' => 'string', 'null' => true),
        'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'alias' => array('type' => 'string', 'null' => true),
        'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );

    public $aros = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'model' => array('type' => 'string', 'null' => true),
        'foreign_key' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'alias' => array('type' => 'string', 'null' => true),
        'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );

    public $aros_acos = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
        'aro_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
        'aco_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
        '_create' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
        '_read' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
        '_update' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
        '_delete' => array('type' => 'string', 'null' => false, 'default' => '0', 'length' => 2),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id', 'unique' => 1),
            'ARO_ACO_KEY' => array('column' => array('aro_id', 'aco_id'), 'unique' => 1)
        )
    );
}
