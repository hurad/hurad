<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
        'firstname' => array('type' => 'string', 'length' => 100, 'null' => false),
        'lastname' => array('type' => 'string', 'length' => 100, 'null' => false),
        'nicename' => array('type' => 'string', 'length' => 50, 'null' => false),
        'display_name' => array('type' => 'string', 'length' => 250, 'null' => false),
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
        array('username' => 'atkrad', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'firstname' => 'Hasan', 'lastname' => 'Abdolirad', 'created' => '2007-03-17 01:16:23', 'modified' => '2007-03-17 01:18:31'),
        array('username' => 'rad', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'firstname' => 'Davood', 'lastname' => 'Abdoli Rad', 'created' => '2007-03-17 01:18:23', 'modified' => '2007-03-17 01:20:31'),
        array('username' => 'mohammad', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'firstname' => 'Mohammad', 'lastname' => 'Abdolirad', 'created' => '2007-03-17 01:20:23', 'modified' => '2007-03-17 01:22:31'),
        array('username' => 'ali', 'password' => '5f4dcc3b5aa765d61d8327deb882cf99', 'firstname' => 'Ali', 'lastname' => 'Abdolirad', 'created' => '2007-03-17 01:22:23', 'modified' => '2007-03-17 01:24:31'),
    );

}

?>
