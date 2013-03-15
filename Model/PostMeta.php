<?php

App::uses('AppModel', 'Model');

class PostMeta extends AppModel {

    public $belongsTo = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function getPostMeta($post_id, $meta_key) {
        $this->recursive = -1;
        return $this->find('first', array(
                    'fields' => array('meta_value'),
                    'conditions' => array(
                        'PostMeta.post_id' => $post_id,
                        'PostMeta.meta_key' => $meta_key,
                    )
        ));
    }

}