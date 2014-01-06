<?php
/**
 * Category fixture
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
 * Class CategoryFixture
 */
class CategoryFixture extends CakeTestFixture
{

    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'Category';

    /**
     * Full Table Name
     *
     * @var string
     */
    public $table = 'categories';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'parent_id' => ['type' => 'integer', 'null' => true],
        'name' => ['type' => 'string', 'length' => 200, 'null' => false],
        'slug' => ['type' => 'string', 'length' => 200, 'null' => false],
        'lft' => ['type' => 'integer', 'null' => false],
        'rght' => ['type' => 'integer', 'null' => false],
        'description' => ['type' => 'text', 'null' => false],
        'post_count' => ['type' => 'integer', 'null' => false],
        'path' => ['type' => 'string', 'length' => 250, 'null' => false],
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
            'parent_id' => 'NULL',
            'name' => 'PHP',
            'slug' => 'php',
            'lft' => '1',
            'rght' => '2',
            'description' => 'PHP category description',
            'post_count' => '2',
            'path' => 'PHP',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ],
    ];
}
