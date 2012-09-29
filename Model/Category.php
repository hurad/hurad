<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 * @property Post $Post
 */
class Category extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Acts As
     *
     * @var array
     */
    public $actsAs = array('Tree', 'Containable');

    /**
     * belongsTo associations
     *
     * @var array
     */
//    public $belongsTo = array(
//        'ParentCategory' => array(
//            'className' => 'Category',
//            'foreignKey' => 'parent_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => ''
//        )
//    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ChildCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
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

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Post' => array(
            'className' => 'Post',
            'joinTable' => 'categories_posts',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'post_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

    public function count_cats() {

        $cats = $this->find('count');

        return $cats;
    }

}
