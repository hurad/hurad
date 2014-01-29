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
            'dependent' => true
        ],
        'PostMeta' => [
            'className' => 'PostMeta',
            'foreignKey' => 'post_id',
            'dependent' => true
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

    const STATUS_TRASH = 0;
    const STATUS_DRAFT = 1;
    const STATUS_PENDING = 2;
    const STATUS_PUBLISH = 3;

    const COMMENT_STATUS_DISABLE = 0;
    const COMMENT_STATUS_CLOSE = 1;
    const COMMENT_STATUS_OPEN = 2;

    /**
     * Get post statuses
     *
     * @param null|array $status
     *
     * @return array|string
     */
    public static function getStatus($status = null)
    {
        $statuses = [
            self::STATUS_PUBLISH => __d('hurad', 'Publish'),
            self::STATUS_PENDING => __d('hurad', 'Pending'),
            self::STATUS_DRAFT => __d('hurad', 'Draft'),
            self::STATUS_TRASH => __d('hurad', 'Trash')
        ];

        return parent::enum($status, $statuses);
    }

    /**
     * Get comment statuses
     *
     * @param null|array $status
     *
     * @return array|string
     */
    public static function getCommentStatus($status = null)
    {
        $statuses = [
            self::COMMENT_STATUS_OPEN => __d('hurad', 'Open'),
            self::COMMENT_STATUS_CLOSE => __d('hurad', 'Close'),
            self::COMMENT_STATUS_DISABLE => __d('hurad', 'Disable')
        ];

        return parent::enum($status, $statuses);
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
     * @throws CakeException
     * @return int Number of all posts in specify status.
     */
    public function countPosts($status = 'all')
    {
        $this->unbindModel(['hasOne' => ['CategoriesPost', 'PostsTag']]);
        switch ($status) {
            case 'all':
                $status = [self::STATUS_PUBLISH, self::STATUS_PENDING, self::STATUS_DRAFT];
                break;

            case 'publish':
                $status = self::STATUS_PUBLISH;
                break;

            case 'pending':
                $status = self::STATUS_PENDING;
                break;

            case 'draft':
                $status = self::STATUS_DRAFT;
                break;

            case 'trash':
                $status = self::STATUS_TRASH;
                break;

            default:
                throw new CakeException(__d('hurad', 'Status "%s" not found.', $status));
                break;
        }

        $count = $this->find('count', ['conditions' => ['Post.status' => $status, 'Post.type' => 'post']]);

        return $count;
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
                'conditions' => ['Post.status' => self::STATUS_PUBLISH, 'Post.type' => 'post'],
                'limit' => $limit,
                'order' => [
                    'Post.created' => 'desc'
                ]
            ]
        );

        return $latestPosts;
    }
}
