<?php
/**
 * Installer model
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
 * Class Installer
 */
class Installer extends AppModel
{
    /**
     * Custom database table name, or null/false if no table association is desired.
     *
     * @var string
     */
    public $useTable = false;

    /**
     * Name of the validation string domain to use when translating validation errors.
     *
     * @var string
     */
    public $validationDomain = 'hurad';

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'database' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.'
            ]
        ],
        'login' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.'
            ]
        ],
        'password' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.'
            ]
        ],
        'host' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.'
            ]
        ],
        'prefix' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'This field cannot be left blank.'
            ]
        ],
        'site_title' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'Site title cannot be left blank.'
            ]
        ],
        'site_username' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'Admin username cannot be left blank.'
            ]
        ],
        'site_password' => [
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'Password cannot be left blank.'
            ]
        ],
        'site_confirm_password' => [
            'equalTo' => [
                'rule' => ['checkPasswords', 'site_password'],
                'message' => 'This value must be equal to password.'
            ]
        ],
        'email' => [
            'email' => [
                'rule' => ['email'],
                'message' => 'Please supply a valid email address.'
            ]
        ],
    ];

    public function checkPasswords()
    {
        if ($this->data['Installer']['site_confirm_password'] === $this->data['Installer']['site_password']) {
            return true;
        } else {
            return false;
        }

    }
}
