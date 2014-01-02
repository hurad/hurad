<?php
/**
 * User fixture
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
 * Class UserFixture
 */
class UserFixture extends CakeTestFixture
{
    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'username' => ['type' => 'string', 'length' => 60, 'null' => false],
        'password' => ['type' => 'string', 'length' => 64, 'null' => false],
        'email' => ['type' => 'string', 'length' => 100, 'null' => false],
        'url' => ['type' => 'string', 'length' => 100, 'null' => false],
        'role' => ['type' => 'string', 'length' => 20, 'null' => false],
        'activation_key' => ['type' => 'string', 'length' => 60, 'null' => false],
        'reset_key' => ['type' => 'string', 'length' => 60, 'null' => false],
        'status' => ['type' => 'integer', 'null' => false],
        'created' => 'datetime',
        'modified' => 'datetime'
    ];

    /**
     * Fixture records to be inserted.
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'admin@example.org',
            'url' => '',
            'role' => 'admin',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2013-03-17 01:16:23',
            'modified' => '2013-03-17 01:16:23'
        ],
        [
            'id' => 2,
            'username' => 'editor',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'editor@example.org',
            'url' => '',
            'role' => 'editor',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2013-03-18 01:18:23',
            'modified' => '2013-03-18 01:18:23'
        ],
        [
            'id' => 3,
            'username' => 'author',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'author@example.org',
            'url' => '',
            'role' => 'author',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2013-03-19 01:20:23',
            'modified' => '2013-03-19 01:20:23'
        ],
        [
            'id' => 4,
            'username' => 'user',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'user@example.org',
            'url' => '',
            'role' => 'user',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2013-03-20 01:22:23',
            'modified' => '2013-03-20 01:22:23'
        ],
    ];
}
