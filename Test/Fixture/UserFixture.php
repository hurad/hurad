<?php

/**
 * Description of UserFixture
 *
 * @author mohammad
 */
class UserFixture extends CakeTestFixture {

    /**
     * name property
     *
     * @var string 'User'
     * @access public
     */
    public $name = 'User';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'username' => array('type' => 'string', 'length' => 60, 'null' => false),
        'password' => array('type' => 'string', 'length' => 64, 'null' => false),
        'email' => array('type' => 'string', 'length' => 100, 'null' => false),
        'url' => array('type' => 'string', 'length' => 100, 'null' => false),
        'role' => array('type' => 'string', 'length' => 20, 'null' => false),
        'activation_key' => array('type' => 'string', 'length' => 60, 'null' => false),
        'reset_key' => array('type' => 'string', 'length' => 60, 'null' => false),
        'status' => array('type' => 'integer', 'null' => false),
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
            'id' => 1,
            'username' => 'admin',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'admin@example.org',
            'url' => '',
            'role' => 'admin',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:18:31'
        ),
        array(
            'id' => 2,
            'username' => 'editor',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'editor@example.org',
            'url' => '',
            'role' => 'editor',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2007-03-17 01:18:23',
            'modified' => '2007-03-17 01:20:31'
        ),
        array(
            'id' => 3,
            'username' => 'author',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'author@example.org',
            'url' => '',
            'role' => 'author',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2007-03-17 01:20:23',
            'modified' => '2007-03-17 01:22:31'
        ),
        array(
            'id' => 4,
            'username' => 'user',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'user@example.org',
            'url' => '',
            'role' => 'user',
            'activation_key' => '',
            'reset_key' => '',
            'status' => 0,
            'created' => '2007-03-17 01:22:23',
            'modified' => '2007-03-17 01:24:31'
        ),
    );

}