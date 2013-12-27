<?php

/**
 * Class CommentFixture
 */
class CommentFixture extends CakeTestFixture
{

    /**
     * name property
     *
     * @var string 'Comment'
     * @access public
     */
    public $name = 'Comment';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => true),
        'post_id' => array('type' => 'integer', 'null' => false),
        'user_id' => array('type' => 'integer', 'null' => false),
        'author' => array('type' => 'string', 'length' => 255, 'null' => false),
        'author_email' => array('type' => 'string', 'length' => 100, 'null' => false),
        'author_url' => array('type' => 'string', 'length' => 200, 'null' => false),
        'author_ip' => array('type' => 'string', 'length' => 100, 'null' => false),
        'content' => array('type' => 'text', 'null' => false),
        'status' => array('type' => 'string', 'length' => 20, 'null' => false),
        'agent' => array('type' => 'string', 'length' => 255, 'null' => false),
        'lft' => array('type' => 'integer', 'null' => false),
        'rght' => array('type' => 'integer', 'null' => false),
        'created' => 'datetime',
        'modified' => 'datetime'
    );

    /**
     * records property
     *
     * @var array
     * @access public
     */
    public $records = array(
        array(
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
        ),
    );

}