<?php

/**
 * Class UserMetaFixture
 */
class UserMetaFixture extends CakeTestFixture
{

    /**
     * name property
     *
     * @var string
     * @access public
     */
    public $name = 'UserMeta';
    public $table = 'user_metas';

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
        array('id' => 1, 'user_id' => 1, 'meta_key' => 'firstname', 'meta_value' => 'Mohammad'),
        array('id' => 2, 'user_id' => 1, 'meta_key' => 'lastname', 'meta_value' => 'Abdoli Rad'),
        array('id' => 3, 'user_id' => 1, 'meta_key' => 'nickname', 'meta_value' => 'atkrad'),
        array('id' => 4, 'user_id' => 1, 'meta_key' => 'bio', 'meta_value' => ''),
        array('id' => 5, 'user_id' => 1, 'meta_key' => 'display_name', 'meta_value' => 'Mohammad'),
        array('id' => 6, 'user_id' => 2, 'meta_key' => 'firstname', 'meta_value' => 'Ali'),
        array('id' => 7, 'user_id' => 2, 'meta_key' => 'lastname', 'meta_value' => 'Rad'),
        array('id' => 8, 'user_id' => 2, 'meta_key' => 'nickname', 'meta_value' => 'atkrad67'),
        array('id' => 9, 'user_id' => 2, 'meta_key' => 'bio', 'meta_value' => ''),
        array('id' => 10, 'user_id' => 2, 'meta_key' => 'display_name', 'meta_value' => 'ali')
    );

}