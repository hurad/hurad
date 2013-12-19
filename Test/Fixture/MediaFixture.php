<?php

/**
 * Class MediaFixture
 */
class MediaFixture extends CakeTestFixture
{

    /**
     * Name
     *
     * @var string
     */
    public $name = 'Media';

    /**
     * Fields
     *
     * @var array
     */
    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false),
        'title' => array('type' => 'string', 'length' => 255, 'null' => false),
        'description' => array('type' => 'text', 'null' => false),
        'name' => array('type' => 'string', 'length' => 255, 'null' => false),
        'original_name' => array('type' => 'string', 'length' => 255, 'null' => false),
        'mime_type' => array('type' => 'string', 'length' => 255, 'null' => false),
        'size' => array('type' => 'integer', 'null' => false),
        'extension' => array('type' => 'string', 'length' => 5, 'null' => false),
        'path' => array('type' => 'string', 'length' => 12, 'null' => false),
        'web_path' => array('type' => 'text', 'null' => false),
        'created' => 'datetime',
        'modified' => 'datetime'
    );
}
