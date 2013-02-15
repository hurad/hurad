<?php

App::uses('AppModel', 'Model');

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
        )
    );
    public $validate = array(
        'username' => array(
            'usernameRule-1' => array(
                'rule' => array('minLength', 5),
                'message' => 'Minimum length of 5 characters',
                'last' => true
            ),
            'usernameRule-2' => array(
                'rule' => 'isUnique',
                'message' => 'This username has already been taken.'
            ),
            'usernameRule-3' => array(
                'rule' => 'notEmpty',
                'message' => 'This username has already been taken.'
            )
        ),
        'password' => array(
            'rule' => array('between', 5, 32),
            'message' => 'Passwords must be between 5 and 32 characters long.'
        ),
        'confirm_password' => array(
            'rule' => 'checkPasswords',
            'message' => 'Entered passwords do not match.'
        ),
//        'password_old' => array(
//            'rule' => 'password_old',
//            'message' => 'Do not match',
//        ),
        'email' => array(
            'emailRule-1' => array(
                'rule' => 'email',
                'message' => 'Please enter valid email.'
            ),
            'emailRule-2' => array(
                'rule' => 'isUnique',
                'message' => 'This email has already exist.',
                'last' => true
            ),
        )
    );

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        if ($this->request->params['action'] == 'admin_profile') {
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

    function checkPasswords() {
        if ($this->data['User']['confirm_password'] === $this->data['User']['password']) {
            return true;
        } else {
            return false;
        }
    }

    function get_userdata($user_id) {
        $user = $this->find('first', array(
            "fields" => 'User.id, User.nickname',
            "conditions" => array('User.id' => $user_id),
            "recursive" => 0
                )
        );
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