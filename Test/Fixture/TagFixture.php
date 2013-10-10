<?php

/**
 * Class TagFixture
 */
class TagFixture extends CakeTestFixture
{

    /**
     * name property
     *
     * @var string 'Tag'
     * @access public
     */
    public $name = 'Tag';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'name' => array('type' => 'string', 'length' => 200, 'null' => false),
        'slug' => array('type' => 'string', 'length' => 200, 'null' => false),
        'description' => array('type' => 'text', 'null' => false),
        'post_count' => array('type' => 'integer', 'null' => false),
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
            'name' => 'CSS',
            'slug' => 'css',
            'description' => 'CSS tag description',
            'post_count' => '5',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:16:23'
        ),
    );

}