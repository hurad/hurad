<?php
/**
 * Category model
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

/**
 * Class Category
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 * @property Post     $Post
 */
class Category extends AppModel
{
    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'nameRule-1' => [
                'rule' => 'notEmpty',
            ]
        ],
        'slug' => [
            'slugRule-1' => [
                'rule' => 'notEmpty',
                'last' => true
            ],
            'slugRule-2' => [
                'rule' => 'isUnique',
            ]
        ]
    ];

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['Tree', 'Containable'];

    /**
     * Detailed list of hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'ChildCategory' => [
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'dependent' => false
        ]
    ];

    /**
     * Detailed list of hasAndBelongsToMany associations.
     *
     * @var array
     */
    public $hasAndBelongsToMany = [
        'Post' => [
            'className' => 'Post',
            'joinTable' => 'categories_posts',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'post_id',
            'unique' => 'keepExisting'
        ]
    ];

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
                        "INSERT INTO `categories_posts` (`category_id`, `post_id`) VALUES ('1', '" . $value['id'] . "');"
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
                                'CategoriesPost.category_id' => 1,
                            )
                        )
                    ),
                    'group' => 'post_id'
                )
            );
            $this->query("UPDATE `categories` SET `post_count` = '" . $post_count . "' WHERE `categories`.`id` = 1;");
        }
    }

    /**
     * Called after each successful save operation.
     *
     * @param boolean $created True if this save created a new record
     * @param array   $options Options passed from Model::save().
     *
     * @return void
     * @see  Model::save()
     */
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

        if ($this->id == '1' && isset($this->data['Category']['parent_id'])) {
            return false;
        }
    }

    public function count_cats()
    {

        $cats = $this->find('count');

        return $cats;
    }

    public function getBySlug($slug)
    {
        $category = $this->find('first', ['conditions' => ['Category.slug' => $slug]]);

        return $category;
    }
}
