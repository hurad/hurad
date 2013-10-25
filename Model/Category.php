<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 * @property Post $Post
 */
class Category extends AppModel
{

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

    public function beforeDelete($cascade = true)
    {
        parent::beforeDelete($cascade);
        $action = $this->request->params['action'];
        if ($action == 'admin_delete') {
            $cat = $this->find(
                'first',
                array(
                    'conditions' => array('Category.id' => $this->request->params['pass'][0])
                )
            );
            if (count($cat['Post']) > 0) {
                foreach ($cat['Post'] as $key => $value) {
                    $this->query("DELETE FROM `categories_posts` WHERE `categories_posts`.`post_id` = " . $value['id']);
                    $this->query(
                        "INSERT INTO `categories_posts` (`category_id`, `post_id`) VALUES ('37', '" . $value['id'] . "');"
                    );
                }
            }
            $post_count = $this->find(
                'count',
                array(
                    'joins' => array(
                        array(
                            'table' => 'categories_posts',
                            'alias' => 'CategoriesPost',
                            'type' => 'INNER',
                            'conditions' => array(
                                'CategoriesPost.category_id' => 37,
                            )
                        )
                    ),
                    'group' => 'post_id'
                )
            );
            $this->query("UPDATE `categories` SET `post_count` = '" . $post_count . "' WHERE `categories`.`id` =37;");
        }
    }

    public function afterSave($created, $options = array())
    {
        parent::afterSave($created);
        $action = $this->request->params['action'];
        if ($action == 'admin_add' || $action == 'admin_edit') {
            $path = $this->getPath($this->id);
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
                array('Category.path' => "'$path_field'"),
                array('Category.id' => $this->id)
            );
        }
        if ($action == 'admin_process') {
            $path = $this->getPath($this->id);
            $path_num = count($path) - 1;
            $category = $this->findById($this->id);
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
                array('Category.path' => "'$path_field'"),
                array('Category.id' => $this->id)
            );
        }
    }

    public function beforeSave($options = array())
    {
        parent::beforeSave($options);

        if ($this->id == '1' && isset($this->data['Category']['parent_id'])) {
            return false;
        }
    }

    public function count_cats()
    {

        $cats = $this->find('count');

        return $cats;
    }

}
