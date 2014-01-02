<?php
/**
 * Link model
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
App::uses('AppModel', 'Model');

/**
 * Class Link
 *
 * @property Menu $Menu
 */
class Link extends AppModel
{
    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['Tree'];

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'nameRule-1' => [
                'rule' => 'notEmpty',
            ]
        ],
        'url' => [
            'urlRule-1' => [
                'rule' => 'notEmpty',
                'last' => true
            ],
            'urlRule-2' => [
                'rule' => 'url',
            ]
        ]
    ];


    /**
     * Detailed list of belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'Menu' => [
            'className' => 'Menu',
            'foreignKey' => 'menu_id'
        ],
        'Linkcat' => [
            'className' => 'Linkcat',
            'foreignKey' => 'menu_id',
            'counterCache' => true
        ]
    ];
}
