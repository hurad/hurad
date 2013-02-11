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

    public function afterSave($created) {
        parent::afterSave($created);
        $action = $this->request->params['action'];
        if ($action == 'admin_add' || $action == 'admin_edit') {
            $path = $this->getPath($this->data['Category']['id']);
            $path_num = count($path) - 1;

            if ($path_num > 0) {
                $under = "";
                for ($i = 0; $i < $path_num; $i++) {
                    $under .= "_";
                }
                $path_field = $under . $this->data['Category']['name'];
            } elseif ($path_num == 0) {
                $path_field = $this->data['Category']['name'];
            }
            $this->updateAll(
                    array('Category.path' => "'$path_field'"), array('Category.id' => $this->data['Category']['id'])
            );
        }
        if ($action == 'admin_process') {
            $path = $this->getPath($this->data['Category']['id']);
            $path_num = count($path) - 1;
            $category = $this->findById($this->data['Category']['id']);
            if ($path_num > 0) {
                $under = "";
                for ($i = 0; $i < $path_num; $i++) {
                    $under .= "_";
                }
                $path_field = $under . $category['Category']['name'];
            } elseif ($path_num == 0) {
                $path_field = $category['Category']['name'];
            }
            $this->updateAll(
                    array('Category.path' => "'$path_field'"), array('Category.id' => $this->data['Category']['id'])
            );
        }
    }

    public function count_cats() {

        $cats = $this->find('count');

        return $cats;
    }

}
