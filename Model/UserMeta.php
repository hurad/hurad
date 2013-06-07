<?php

App::uses('AppModel', 'Model');

class UserMeta extends AppModel {

    public $useTable = 'user_metas';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function addMeta($meta_key, $meta_value, $user_id) {
        $userMeta = $this->find('first', array(
            'conditions' => array(
                'meta_key' => $meta_key,
                'user_id' => $user_id
            )
        ));

        if (!isset($userMeta['UserMeta']['id'])) {
            $userMeta['user_id'] = $user_id;
            $userMeta['meta_key'] = $meta_key;
            $userMeta['meta_value'] = $meta_value;

            $this->id = false;
            if ($this->save($userMeta)) {
                return true;
            } else {
                return false;
            }
        }
    }

}