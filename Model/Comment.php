<?php

App::uses('AppModel', 'Model');

/**
 * Comment Model
 *
 * @property Comment $ParentComment
 * @property Post $Post
 * @property User $User
 * @property Comment $ChildComment
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
     * @param int $commentId Comment id
     * @param array $query Find query
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
     * @param int $postId Post id
     * @param string $type Find type, Default: "all"
     * @param array $query Find query
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

    public function countComments($type = 'all')
    {
        if ($type == null) {
            return false;
        } elseif ($type == 'all') {
            $comments = $this->find('count');
        } elseif ($type == 'approved') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                        array('Comment.status' => 'approved')
                )
            );
        } elseif ($type == 'moderated') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                        array('Comment.status' => 'disapproved')
                )
            );
        } elseif ($type == 'spam') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                        array('Comment.status' => 'spam')
                )
            );
        } elseif ($type == 'trash') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                        array('Comment.status' => 'trash')
                )
            );
        } else {
            return false;
        }
        return $comments;
    }
}
