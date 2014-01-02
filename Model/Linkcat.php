<?php
/**
 * Linkcat model
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
 * Class Linkcat
 *
 * @property Link $Link
 */
class Linkcat extends AppModel
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
        'slug' => [
            'slugRule-1' => [
                'rule' => 'notEmpty',
                'last' => true
            ],
            'slugRule-2' => [
                'rule' => 'isUnique',
            ]
        ]
    ];

    /**
     * Custom database table name, or null/false if no table association is desired.
     *
     * @var string
     */
    public $useTable = 'menus';

    /**
     * Detailed list of hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'Link' => [
            'className' => 'Link',
            'foreignKey' => 'menu_id',
            'dependent' => false
        ]
    ];
}
