<?php
/**
 * Post fixture
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
 * Class PostFixture
 */
class PostFixture extends CakeTestFixture
{

    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'Post';

    /**
     * Full Table Name
     *
     * @var string
     */
    public $table = 'posts';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'parent_id' => ['type' => 'integer', 'null' => true],
        'user_id' => ['type' => 'integer', 'null' => false],
        'title' => ['type' => 'text', 'null' => false],
        'slug' => ['type' => 'text', 'null' => false],
        'content' => ['type' => 'text', 'null' => false],
        'excerpt' => ['type' => 'text', 'null' => false],
        'status' => ['type' => 'string', 'length' => 50, 'null' => false],
        'comment_status' => ['type' => 'string', 'length' => 20, 'null' => false],
        'comment_count' => ['type' => 'integer', 'null' => false],
        'type' => ['type' => 'string', 'length' => 20, 'null' => false],
        'lft' => ['type' => 'integer', 'null' => false],
        'rght' => ['type' => 'integer', 'null' => false],
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
            'parent_id' => null,
            'user_id' => '1',
            'title' => 'Post title',
            'slug' => 'post-slug',
            'content' => 'Post content',
            'excerpt' => 'Post excerpt',
            'status' => 'publish',
            'comment_status' => 'open',
            'comment_count' => '20',
            'type' => 'post',
            'lft' => '1',
            'rght' => '2',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ]
    ];
}
