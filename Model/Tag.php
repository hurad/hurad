<?php

App::uses('AppModel', 'Model');

/**
 * Tag Model
 *
 * @property Post $Post
 */
class Tag extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $validate = array(
        'name' => array(
            'nameRule-1' => array(
                'rule' => 'notEmpty',
            )
        ),
        'slug' => array(
            'slugRule-1' => array(
                'rule' => 'notEmpty',
                'last' => true
            ),
            'slugRule-2' => array(
                'rule' => 'isUnique',
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Post' => array(
            'className' => 'Post',
            'joinTable' => 'posts_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'post_id',
            //'unique' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => '',
        )
    );

    public function count_tags() {

        $tags = $this->find('count');

        return $tags;
    }

}
