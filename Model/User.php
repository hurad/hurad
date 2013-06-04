<?php

App::uses('AppModel', 'Model');
App::uses('UserMeta', 'Model');

/**
 * User Model
 *
 * @property Comment $Comment
 * @property Post $Post
 */
class User extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
    public $actsAs = array('Containable');

//The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UserMeta' => array(
            'className' => 'UserMeta',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            //'fields' => array('meta_key', 'meta_value'),
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    public $validate = array(
        'username' => array(
            'usernameRule-1' => array(
                'rule' => array('minLength', 5),
                'last' => true
            ),
            'usernameRule-2' => array(
                'rule' => 'isUnique',
            ),
            'usernameRule-3' => array(
                'rule' => 'notEmpty',
            )
        ),
        'email' => array(
            'emailRule-1' => array(
                'rule' => 'email',
            ),
            'emailRule-2' => array(
                'rule' => 'isUnique',
                'last' => true
            ),
        ),
        'url' => array(
            'urlRule-1' => array(
                'rule' => 'url',
                'allowEmpty' => true
            ),
        ),
        'password' => array(
            'passwordRule-1' => array(
                'rule' => array('between', 5, 32),
            )
        ),
        'confirm_password' => array(
            'confirmPasswordRule-1' => array(
                'rule' => 'checkPasswords',
            )
        )
    );

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        if (Router::getParam('action') == 'admin_profile') {
            if ($this->data['User']['password'] == "" && $this->data['User']['confirm_password'] == "") {
                unset($this->data['User']['password']);
                unset($this->data['User']['confirm_password']);
            }
        }
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
    }

    public function afterSave($created) {
        parent::afterSave($created);

        if ($created) {
            $userMetaData = array(
                'firstname' => '',
                'lastname' => '',
                'nickname' => $this->data['User']['username'],
                'bio' => '',
                'display_name' => $this->data['User']['username']
            );
            foreach ($userMetaData as $meta_key => $meta_value) {
                $this->UserMeta->addMeta($meta_key, $meta_value, $this->id);
            }
        }
    }

    public function afterDelete() {
        parent::afterDelete();
        $this->UserMeta->deleteAll(array('UserMeta.user_id' => $this->id), false);
    }

    function checkPasswords() {
        if ($this->data['User']['confirm_password'] === $this->data['User']['password']) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers($args) {
        $users = $this->find('all', array(
            'order' => array(
                'User.' . $args['orderby'] => $args['order']
            ),
            'limit' => $args['number'],
            'recursive' => 0
        ));
        return $users;
    }

    public function getUserData($user_id) {
        $user = $this->find('first', array(
            "conditions" => array('User.id' => $user_id),
            "recursive" => 0
                )
        );

        $user = $user['User'];

        $metaList = $this->UserMeta->find('list', array(
            'conditions' => array(
                'UserMeta.user_id' => $user_id
            ),
            'fields' => array(
                'UserMeta.meta_key',
                'UserMeta.meta_value'
            ),
        ));

        $user = Set::merge($user, $metaList);

        return $user;
    }

    function password_old() {
        $password = $this->field('password', array('id' => $this->id));
        if ($password == AuthComponent::password($this->data['User']['password_old'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}