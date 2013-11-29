<?php
App::uses('AppModel', 'Model');

/**
 * Class Media
 */
class Media extends AppModel
{

    /**
     * The displayField attribute specifies which database field should be used as a label for the record.
     * The label is used in scaffolding and in find('list') calls.
     *
     * @var string
     * @access public
     */
    public $displayField = 'title';

    /**
     * Define a belongsTo association in the Post model in order to get access to related User data.
     *
     * @var array
     * @access public
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ]
    ];

    public function getMedia($id)
    {
        $this->id = $id;
        if (!$this->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid file'));
        }

        return $this->find('first', ['conditions' => ['Media.id' => $id]]);
    }
}
