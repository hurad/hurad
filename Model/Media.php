<?php
/**
 * Media model
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
 * Class Media
 */
class Media extends AppModel
{
    /**
     * The displayField attribute specifies which database field should be used as a label for the record.
     * The label is used in scaffolding and in find('list') calls.
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Define a belongsTo association in the Post model in order to get access to related User data.
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id'
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
