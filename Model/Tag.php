<?php
/**
 * Tag model
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
 * Class Tag
 *
 * @property Post $Post
 */
class Tag extends AppModel
{
    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'name' => [
            'nameRule-1' => [
                'rule' => 'notEmpty',
            ]
        ],
        'slug' => [
            'slugRule-1' => [
                'rule' => 'notEmpty',
                'last' => true
            ],
            'slugRule-2' => [
                'rule' => 'isUnique',
            ]
        ]
    ];

    /**
     * Detailed list of hasAndBelongsToMany associations.
     *
     * @var array
     */
    public $hasAndBelongsToMany = [
        'Post' => [
            'className' => 'Post',
            'joinTable' => 'posts_tags',
            'foreignKey' => 'tag_id',
            'associationForeignKey' => 'post_id'
        ]
    ];

    public function count_tags()
    {
        $tags = $this->find('count');

        return $tags;
    }

    public function getBySlug($slug)
    {
        $tag = $this->find('first', ['conditions' => ['Tag.slug' => $slug]]);

        return $tag;
    }
}
