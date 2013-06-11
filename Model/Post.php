<?php

App::uses('AppModel', 'Model');

/**
 * Post model for Hurad.
 *
 * Licensed under The GPLv3 License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @package Hurad
 * @category Model
 * @since 1.0.0
 * @license GPLv3 License (http://opensource.org/licenses/GPL-3.0) 
 * @link http://hurad.org Hurad Project
 */
class Post extends AppModel {

    /**
     * The displayField attribute specifies which database field should be used as a label for the record.
     * The label is used in scaffolding and in find('list') calls.
     *
     * @var string
     * @access public
     */
    public $displayField = 'title';

    /**
     * Behaviors are attached to models through the $actsAs model class variable.
     *
     * @var array
     * @access public
     */
    public $actsAs = array('Tree', 'Containable', 'HabtmCounterCache');

    /**
     * Define a belongsTo association in the Post model in order to get access to related User data.
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * A hasMany association will allow us to fetch a post’s comments when we fetch a Post record.
     *
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'post_id',
            'dependent' => false,
            'conditions' => array('Comment.approved' => 1),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ),
        'PostMeta' => array(
            'className' => 'PostMeta',
            'foreignKey' => 'post_id',
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
     * @access public
     */
    public $hasAndBelongsToMany = array(
        'Category' => array(
            'className' => 'Category',
            'joinTable' => 'categories_posts',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'category_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => '',
        ),
        'Tag' => array(
            'className' => 'Tag',
            'joinTable' => 'posts_tags',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'tag_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
        ),
    );

    public function afterDelete() {
        parent::afterDelete();
        $this->UserMeta->deleteAll(array('PostMeta.post_id' => $this->id), false);
    }

    /**
     * Get first post.
     *
     * @since 1.0.0
     * @access public
     * 
     * @param intiger $post_id Post ID
     * @return array
     */
    public function getPost($post_id) {
        $post = $this->find('first', array(
            "conditions" => array('Post.id' => $post_id),
            "recursive" => 0
                )
        );
        return $post;
    }

    /**
     * Count all posts.
     *
     * @since 1.0.0
     * @access public
     * 
     * @param string $status Post status
     * @return intiger Number of all posts in specify type.
     */
    public function countPosts($status = 'all') {
        $this->unbindModel(array('hasOne' => array('CategoriesPost', 'PostsTag')));
        switch ($status) {
            case 'all':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Post.status' => array('publish', 'draft'),
                        'Post.type' => 'post')
                        )
                );
                break;

            case 'publish':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Post.status' => 'publish',
                        'Post.type' => 'post')
                        )
                );
                break;

            case 'draft':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Post.status' => 'draft',
                        'Post.type' => 'post')
                        )
                );
                break;

            case 'trash':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Post.status' => 'trash',
                        'Post.type' => 'post')
                        )
                );
                break;

            default:
                break;
        }
        return $num;
    }

    public function countUserPosts($user_id) {
        $num = $this->find('count', array(
            'conditions' => array(
                'Post.user_id' => $user_id
            )
        ));
        return $num;
    }

}