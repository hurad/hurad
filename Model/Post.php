<?php

App::uses('AppModel', 'Model');

/**
 * Post Model
 *
 * @property User $User
 * @property Comment $Comment
 * @property Category $Category
 * @property Tag $Tag
 */
class Post extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    public $actsAs = array('Tree', 'Containable', 'HabtmCounterCache.HabtmCounterCache');


    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
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
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'post_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
        ),
//        'PostsTag' => array(
//            'className' => 'PostsTag',
//            'foreignKey' => 'post_id',
//            'dependent' => false,
//            'conditions' => '',
//            'fields' => '',
//            'order' => '',
//            'limit' => '',
//            'offset' => '',
//            'exclusive' => '',
//            'finderQuery' => '',
//            'counterQuery' => ''
//        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
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
        //'counterCache' => true
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

    /**
     * Get first post.
     *
     * @param intiger $post_id Post ID
     * @return array
     */
    public function get_post($post_id) {
        $post = $this->find('first', array(
            "fields" => 'Post.id, Post.user_id',
            "conditions" => array('Post.id' => $post_id),
            "recursive" => 0
                )
        );
        return $post;
    }

    /**
     * Count all posts.
     *
     * @return intiger Number of all post published.
     */
    public function count_posts() {
        $published = $this->find('count', array(
            'conditions' => array(
                'Post.status' => 'publish',
                'Post.type' => 'post')
                )
        );
        return $published;
    }

}
