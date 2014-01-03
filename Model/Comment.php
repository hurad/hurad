<?php
/**
 * Comment model
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
 * Class Comment
 *
 * @property Post    $Post
 * @property User    $User
 */
class Comment extends AppModel
{

    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'content';

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index. Eg:
     *
     * public $actsAs = array('Translate', 'MyBehavior' => array('setting1' => 'value1'))
     *
     * @var array
     */
    public $actsAs = ['Tree'];

    /**
     * Detailed list of belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = [
        'Post' => [
            'className' => 'Post',
            'foreignKey' => 'post_id',
            'counterCache' => 'comment_count',
            'counterScope' => ['Comment.status' => 'approved']
        ],
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ]
    ];

    /**
     * Get comment
     *
     * @param int   $commentId Comment id
     * @param array $query     Find query
     *
     * @return array
     */
    public function getComment($commentId = null, $query = [])
    {
        if (!$commentId) {
            $commentId = $this->id;
        }

        $defaultQuery = [
            'conditions' => ['Comment.id' => $commentId],
            'recursive' => -1
        ];

        $query = Hash::merge($defaultQuery, $query);
        $comment = $this->find('first', $query);

        return $comment;
    }

    /**
     * Get comments per post
     *
     * @param int    $postId Post id
     * @param string $type   Find type, Default: "all"
     * @param array  $query  Find query
     *
     * @return array
     */
    public function getComments($postId, $type = 'all', array $query = [])
    {
        if (!$type || $type == '') {
            $type = 'all';
        }

        $defaultQuery = [
            'conditions' => ['post_id' => $postId],
            'recursive' => -1,
            'order' => 'lft ASC'
        ];

        $query = Hash::merge($defaultQuery, $query);
        $comments = $this->find($type, $query);

        return $comments;
    }

    public function getLatest($limit = 5, $status = 'approved')
    {
        $this->recursive = -1;
        $latest = $this->find(
            'all',
            [
                'conditions' => ['Comment.status' => $status],
                'limit' => $limit,
                'order' => [
                    'Comment.created' => 'DESC'
                ]
            ]
        );

        return $latest;
    }

    /**
     * Comment counter
     *
     * @param string $status Comment status
     * @param array  $query  Find query
     *
     * @return array
     */
    public function counter($status = 'all', array $query = [])
    {
        switch ($status) {
            case 'approved':
            case 'disapproved':
            case 'spam':
            case 'trash':
                $defaultQuery = ['conditions' => ['Comment.status' => $status]];
                break;

            case 'all':
                $defaultQuery = ['conditions' => ['Comment.status' => ['approved', 'disapproved']]];
                break;

            default:
                $defaultQuery = [];
                break;
        }

        $query = Hash::merge($defaultQuery, $query);
        $count = $this->find('count', $query);

        return $count;
    }
}
