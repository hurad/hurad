<?php

/**
 * Class CategoryFixture
 */
class CategoryFixture extends CakeTestFixture
{

    /**
     * name property
     *
     * @var string 'Category'
     * @access public
     */
    public $name = 'Category';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'parent_id' => array('type' => 'integer', 'null' => true),
        'name' => array('type' => 'string', 'length' => 200, 'null' => false),
        'slug' => array('type' => 'string', 'length' => 200, 'null' => false),
        'lft' => array('type' => 'integer', 'null' => false),
        'rght' => array('type' => 'integer', 'null' => false),
        'description' => array('type' => 'text', 'null' => false),
        'post_count' => array('type' => 'integer', 'null' => false),
        'path' => array('type' => 'string', 'length' => 250, 'null' => false),
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
            'name' => 'PHP',
            'slug' => 'php',
            'lft' => '1',
            'rght' => '2',
            'description' => 'PHP category description',
            'post_count' => '2',
            'path' => 'PHP',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ),
    );

}