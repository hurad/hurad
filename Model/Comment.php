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
class Comment extends AppModel {

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

    /**
     * hasMany associations
     *
     * @var array
     */
//    public $hasMany = array(
//        'ChildComment' => array(
//            'className' => 'Comment',
//            'foreignKey' => 'parent_id',
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
//    );

    public function countComments($type = 'all') {
        if ($type == NULL) {
            return FALSE;
        } elseif ($type == 'all') {
            $comments = $this->find('count');
        } elseif ($type == 'approved') {
            $comments = $this->find('count', array('conditions' =>
                array('Comment.approved' => 1)
                    )
            );
        } elseif ($type == 'moderated') {
            $comments = $this->find('count', array('conditions' =>
                array('Comment.approved' => 0)
                    )
            );
        } elseif ($type == 'spam') {
            $comments = $this->find('count', array('conditions' =>
                array('Comment.approved' => 'spam')
                    )
            );
        } elseif ($type == 'trash') {
            $comments = $this->find('count', array('conditions' =>
                array('Comment.approved' => 'trash')
                    )
            );
        } else {
            return FALSE;
        }
        return $comments;
    }

}
