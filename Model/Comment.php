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
     * Display field
     *
     * @var string
     */
    public $displayField = 'content';

    /**
     * Acts As
     *
     * @var array
     */
    public $actsAs = array('Tree');

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array('Comment.approved' => 1)
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function getComments($postID, $type = 'all')
    {
        $comments = $this->find(
            $type,
            array(
                'conditions' => array('post_id' => $postID),
                'recursive' => -1,
                'order' => 'lft ASC'
            )
        );
        return $comments;
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
                    array('Comment.approved' => 1)
                )
            );
        } elseif ($type == 'moderated') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                    array('Comment.approved' => 0)
                )
            );
        } elseif ($type == 'spam') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                    array('Comment.approved' => 'spam')
                )
            );
        } elseif ($type == 'trash') {
            $comments = $this->find(
                'count',
                array(
                    'conditions' =>
                    array('Comment.approved' => 'trash')
                )
            );
        } else {
            return false;
        }
        return $comments;
    }

}