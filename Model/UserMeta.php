<?php

App::uses('AppModel', 'Model');

/**
 * Class UserMeta
 */
class UserMeta extends AppModel
{
    /**
     * Custom database table name, or null/false if no table association is desired.
     *
     * @var string
     */
    public $useTable = 'user_meta';

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['KeyValueStorage' => ['key' => 'meta_key', 'value' => 'meta_value', 'foreign_key' => 'user_id']];

    /**
     * Detailed list of belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ]
    ];
}
