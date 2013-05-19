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
class UserMetaFixture extends CakeTestFixture {

    /**
     * name property
     *
     * @var string 'User'
     * @access public
     */
    public $name = 'UserMeta';

    /**
     * fields property
     *
     * @var array
     * @access public
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'length' => 60, 'null' => false),
        'meta_key' => array('type' => 'string', 'length' => 64, 'null' => false),
        'meta_value' => array('type' => 'text', 'null' => false)
    );

    /**
     * records property
     *
     * @var array
     * @access public
     */
    public $records = array(
        array('user_id' => 1, 'meta_key' => 'firstname', 'meta_value' => 'Hasan'),
        array('user_id' => 1, 'meta_key' => 'lastname', 'meta_value' => 'Davood'),
        array('user_id' => 1, 'meta_key' => 'nickname', 'meta_value' => 'Mohammad'),
        array('user_id' => 1, 'meta_key' => 'description', 'meta_value' => 'Ali'),
        array('user_id' => 1, 'meta_key' => 'display_name', 'meta_value' => 'Ali')
    );

}

?>
