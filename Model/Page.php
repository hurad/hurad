<?php

App::uses('AppModel', 'Model');

/**
 * Page Model
 *
 * @property User $User
 * 
 */
class Page extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    public $actsAs = array('Tree', 'Containable');

    /**
     * Use Table
     * This model uses posts table.
     *
     * @var string
     */
    public $useTable = 'posts';

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
    );

    /**
     * Get first page.
     *
     * @param intiger $page_id Page ID
     * @return array
     */
    public function get_page($page_id) {
        $post = $this->find('first', array(
            "fields" => 'Post.id, Post.user_id',
            "conditions" => array('Post.id' => $page_id),
            "recursive" => 0)
        );
        return $post;
    }

    /**
     * Count all pages.
     *
     * @param string $status Page status
     * 
     * @return intiger Number of all pages in specify status.
     */
    public function count_pages($status = 'all') {
        switch ($status) {
            case 'all':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Page.status' => array('publish', 'draft'),
                        'Page.type' => 'page')
                        )
                );
                break;

            case 'publish':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Page.status' => 'publish',
                        'Page.type' => 'page')
                        )
                );
                break;

            case 'draft':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Page.status' => 'draft',
                        'Page.type' => 'page')
                        )
                );
                break;

            case 'trash':
                $num = $this->find('count', array(
                    'conditions' => array(
                        'Page.status' => 'trash',
                        'Page.type' => 'page')
                        )
                );
                break;

            default:
                break;
        }
        return $num;
    }

}
