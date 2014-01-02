<?php
/**
 * Tag fixture
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
 * Class TagFixture
 */
class TagFixture extends CakeTestFixture
{

    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'Tag';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'name' => ['type' => 'string', 'length' => 200, 'null' => false],
        'slug' => ['type' => 'string', 'length' => 200, 'null' => false],
        'description' => ['type' => 'text', 'null' => false],
        'post_count' => ['type' => 'integer', 'null' => false],
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
            'id' => '1',
            'name' => 'CSS',
            'slug' => 'css',
            'description' => 'CSS tag description',
            'post_count' => '5',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ],
    ];
}
