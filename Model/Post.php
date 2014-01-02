<?php
/**
 * Post model
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
 * Class Post
 */
class Post extends AppModel
{

    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['Tree', 'Containable', 'HabtmCounterCache'];

    /**
     * Detailed list of belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ]
    ];

    /**
     * Detailed list of hasMany associations.
     *
     * @var array
     */
    public $hasMany = [
        'Comment' => [
            'className' => 'Comment',
            'foreignKey' => 'post_id',
            'dependent' => false,
            'conditions' => ['Comment.status' => 'approved']
        ],
        'PostMeta' => [
            'className' => 'PostMeta',
            'foreignKey' => 'post_id',
            'dependent' => false,
        ]
    ];

    /**
     * Detailed list of hasAndBelongsToMany associations.
     *
     * @var array
     */
    public $hasAndBelongsToMany = [
        'Category' => [
            'className' => 'Category',
            'joinTable' => 'categories_posts',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'category_id',
            'unique' => 'keepExisting'
        ],
        'Tag' => [
            'className' => 'Tag',
            'joinTable' => 'posts_tags',
            'foreignKey' => 'post_id',
            'associationForeignKey' => 'tag_id',
            'unique' => true
        ],
    ];

    /**
     * Called after every deletion operation.
     *
     * @return void
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->PostMeta->deleteAll(array('PostMeta.post_id' => $this->id), false);
    }

    /**
     * Get first post.
     *
     * @param int   $postId Post id
     * @param array $query  Query options
     *
     * @return array
     */
    public function getPost($postId, array $query = [])
    {
        $defaultQuery = [
            "conditions" => ['Post.id' => $postId, 'Post.type' => 'post'],
            "recursive" => -1
        ];

        $findQuery = Hash::merge($defaultQuery, $query);

        $post = $this->find(
            'first',
            $findQuery
        );

        return $post;
    }

    /**
     * Count all posts.
     *
     * @param string $status Post status
     *
     * @return intiger Number of all posts in specify type.
     */
    public function countPosts($status = 'all')
    {
        $this->unbindModel(array('hasOne' => array('CategoriesPost', 'PostsTag')));
        switch ($status) {
            case 'all':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Post.status' => array('publish', 'draft'),
                            'Post.type' => 'post'
                        )
                    )
                );
                break;

            case 'publish':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Post.status' => 'publish',
                            'Post.type' => 'post'
                        )
                    )
                );
                break;

            case 'draft':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Post.status' => 'draft',
                            'Post.type' => 'post'
                        )
                    )
                );
                break;

            case 'trash':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Post.status' => 'trash',
                            'Post.type' => 'post'
                        )
                    )
                );
                break;

            default:
                break;
        }
        return $num;
    }

    public function countUserPosts($user_id)
    {
        $num = $this->find(
            'count',
            array(
                'conditions' => array(
                    'Post.user_id' => $user_id
                )
            )
        );
        return $num;
    }

    public function getLatestPosts($limit = 5)
    {
        $latestPosts = $this->find(
            'all',
            [
                'conditions' => ['Post.status' => 'publish', 'Post.type' => 'post'],
                'limit' => $limit,
                'order' => [
                    'Post.created' => 'desc'
                ]
            ]
        );

        return $latestPosts;
    }
}
