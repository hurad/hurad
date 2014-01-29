<?php
/**
 * User model
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('AppModel', 'Model');
App::uses('UserMeta', 'Model');

/**
 * Class User
 *
 * @property Comment $Comment
 * @property Post    $Post
 */
class User extends AppModel
{
    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'username';

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['Containable'];

    /**
     * Detailed list of hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'Comment' => [
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false
        ],
        'Post' => [
            'className' => 'Post',
            'foreignKey' => 'user_id',
            'dependent' => false
        ],
        'UserMeta' => [
            'className' => 'UserMeta',
            'foreignKey' => 'user_id',
            'dependent' => true
        ],
        'Media' => [
            'className' => 'Media',
            'foreignKey' => 'user_id',
            'dependent' => false
        ],
    ];

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'username' => [
            'usernameRule-1' => [
                'rule' => ['minLength', 5],
                'last' => true
            ],
            'usernameRule-2' => [
                'rule' => 'isUnique',
            ],
            'usernameRule-3' => [
                'rule' => 'notEmpty',
            ]
        ],
        'email' => [
            'emailRule-1' => [
                'rule' => 'email',
            ],
            'emailRule-2' => [
                'rule' => 'isUnique',
                'last' => true
            ],
        ],
        'url' => [
            'urlRule-1' => [
                'rule' => 'url',
                'allowEmpty' => true
            ],
        ],
        'password' => [
            'passwordRule-1' => [
                'rule' => ['between', 5, 32],
            ]
        ],
        'confirm_password' => [
            'confirmPasswordRule-1' => [
                'rule' => 'checkPasswords',
            ]
        ]
    ];

    /**
     * Called during validation operations, before validation. Please note that custom
     * validation rules can be defined in $validate.
     *
     * @param array $options Options passed from Model::save().
     *
     * @return boolean True if validate operation should continue, false to abort
     * @see Model::save()
     */
    public function beforeValidate($options = [])
    {
        parent::beforeValidate($options);
        if (Router::getParam('action') == 'admin_profile') {
            if ($this->data['User']['password'] == "" && $this->data['User']['confirm_password'] == "") {
                unset($this->data['User']['password']);
                unset($this->data['User']['confirm_password']);
            }
        }
    }

    /**
     * Called before each save operation, after validation. Return a non-true result
     * to halt the save.
     *
     * @param array $options Options passed from Model::save().
     *
     * @return boolean True if the operation should continue, false if it should abort
     * @see Model::save()
     */
    public function beforeSave($options = array())
    {
        parent::beforeSave($options);
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
    }

    /**
     * Called after each successful save operation.
     *
     * @param boolean $created True if this save created a new record
     * @param array   $options Options passed from Model::save().
     *
     * @return void
     * @see Model::save()
     */
    public function afterSave($created, $options = array())
    {
        parent::afterSave($created);

        if ($created) {
            $userMetaData['UserMeta'] = [
                'nickname' => $this->data['User']['username'],
                'display_name' => $this->data['User']['username']
            ];

            $this->UserMeta->user_id = $this->id;
            $this->UserMeta->saveData($userMetaData);
        }
    }

    /**
     * Called before every deletion operation.
     *
     * @param boolean $cascade If true records that depend on this record will also be deleted
     *
     * @return boolean True if the operation should continue, false if it should abort
     */
    public function beforeDelete($cascade = true)
    {
        parent::beforeDelete($cascade);

        if ($this->id == 1) {
            return false;
        }

        return true;
    }

    function checkPasswords()
    {
        if ($this->data['User']['confirm_password'] === $this->data['User']['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers($args)
    {
        $defaults = [
            'order_by' => 'username',
            'order' => 'ASC',
            'limit' => 5
        ];

        $args = Hash::merge($defaults, $args);

        $users = $this->find(
            'all',
            array(
                'order' => array(
                    'User.' . $args['order_by'] => $args['order']
                ),
                'limit' => $args['limit'],
                'recursive' => 0
            )
        );

        return $users;
    }

    /**
     * Get user
     *
     * @param int   $userId User id
     * @param array $query  Find query
     *
     * @return array|bool If user exist return array else return false
     */
    public function getUser($userId = null, array $query = [])
    {
        if (!$userId) {
            $userId = $this->id;
        }

        $defaultQuery = [
            "conditions" => ['User.id' => $userId],
            "recursive" => -1
        ];

        $query = Hash::merge($defaultQuery, $query);

        $user = $this->find('first', $query);

        if ($user) {
            $userMeta = $this->UserMeta->getData($userId);
            $output = Hash::merge($user, $userMeta);
            return $output;
        } else {
            return false;
        }
    }
}
