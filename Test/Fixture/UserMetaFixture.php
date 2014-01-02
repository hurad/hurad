<?php
/**
 * User Meta fixture
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
 * Class UserMetaFixture
 */
class UserMetaFixture extends CakeTestFixture
{
    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'UserMeta';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'user_id' => ['type' => 'integer', 'length' => 60, 'null' => false],
        'meta_key' => ['type' => 'string', 'length' => 64, 'null' => false],
        'meta_value' => ['type' => 'text', 'null' => false]
    ];

    /**
     * Fixture records to be inserted.
     *
     * @var array
     */
    public $records = [
        ['id' => 1, 'user_id' => 1, 'meta_key' => 'first_name', 'meta_value' => 'Mohammad'],
        ['id' => 2, 'user_id' => 1, 'meta_key' => 'last_name', 'meta_value' => 'Abdoli Rad'],
        ['id' => 3, 'user_id' => 1, 'meta_key' => 'nickname', 'meta_value' => 'atkrad'],
        ['id' => 4, 'user_id' => 1, 'meta_key' => 'bio', 'meta_value' => ''],
        ['id' => 5, 'user_id' => 1, 'meta_key' => 'display_name', 'meta_value' => 'Mohammad'],
        ['id' => 6, 'user_id' => 2, 'meta_key' => 'first_name', 'meta_value' => 'Ali'],
        ['id' => 7, 'user_id' => 2, 'meta_key' => 'last_name', 'meta_value' => 'Rad'],
        ['id' => 8, 'user_id' => 2, 'meta_key' => 'nickname', 'meta_value' => 'atkrad67'],
        ['id' => 9, 'user_id' => 2, 'meta_key' => 'bio', 'meta_value' => ''],
        ['id' => 10, 'user_id' => 2, 'meta_key' => 'display_name', 'meta_value' => 'ali']
    ];
}
