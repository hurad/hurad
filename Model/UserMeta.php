<?php

App::uses('AppModel', 'Model');

/**
 * Class UserMeta
 */
class UserMeta extends AppModel
{

    public $useTable = 'user_metas';
    public $actsAs = ['KeyValueStorage' => ['key' => 'meta_key', 'value' => 'meta_value', 'foreign_key' => 'user_id']];
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
}