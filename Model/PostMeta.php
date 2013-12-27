<?php

App::uses('AppModel', 'Model');

/**
 * Class PostMeta
 */
class PostMeta extends AppModel
{

    /**
     * Custom database table name, or null/false if no table association is desired.
     *
     * @var string
     */
    public $useTable = 'post_meta';

    /**
     * Detailed list of belongsTo associations.
     *
     * @var array
     */
    public $belongsTo = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
        )
    );

    public function getPostMeta($post_id, $meta_key)
    {
        $this->recursive = -1;
        return $this->find(
            'first',
            array(
                'fields' => array('meta_value'),
                'conditions' => array(
                    'PostMeta.post_id' => $post_id,
                    'PostMeta.meta_key' => $meta_key,
                )
            )
        );
    }
}
