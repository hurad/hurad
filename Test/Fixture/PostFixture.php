<?php

/**
 * Class PostFixture
 */
class PostFixture extends CakeTestFixture
{

    /**
     * name property
     *
     * @var string 'Post'
     * @access public
     */
    public $name = 'Post';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => true),
        'user_id' => array('type' => 'integer', 'null' => false),
        'title' => array('type' => 'text', 'null' => false),
        'slug' => array('type' => 'text', 'null' => false),
        'content' => array('type' => 'text', 'null' => false),
        'excerpt' => array('type' => 'text', 'null' => false),
        'status' => array('type' => 'string', 'length' => 50, 'null' => false),
        'comment_status' => array('type' => 'string', 'length' => 20, 'null' => false),
        'comment_count' => array('type' => 'integer', 'null' => false),
        'type' => array('type' => 'string', 'length' => 20, 'null' => false),
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
        )
    );

}