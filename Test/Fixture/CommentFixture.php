<?php
/**
 * Comment fixture
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
 * Class CommentFixture
 */
class CommentFixture extends CakeTestFixture
{
    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'Comment';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'parent_id' => ['type' => 'integer', 'null' => true],
        'post_id' => ['type' => 'integer', 'null' => false],
        'user_id' => ['type' => 'integer', 'null' => false],
        'author' => ['type' => 'string', 'length' => 255, 'null' => false],
        'author_email' => ['type' => 'string', 'length' => 100, 'null' => false],
        'author_url' => ['type' => 'string', 'length' => 200, 'null' => false],
        'author_ip' => ['type' => 'string', 'length' => 100, 'null' => false],
        'content' => ['type' => 'text', 'null' => false],
        'status' => ['type' => 'string', 'length' => 20, 'null' => false],
        'agent' => ['type' => 'string', 'length' => 255, 'null' => false],
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
            'parent_id' => 'NULL',
            'post_id' => '1',
            'user_id' => '1',
            'author' => 'Author name',
            'author_email' => 'author@test.com',
            'author_url' => 'http://test.com',
            'author_ip' => '127.0.0.1',
            'content' => 'Test comment content',
            'status' => 'approved',
            'agent' => '',
            'lft' => '1',
            'rght' => '2',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ],
    ];
}
