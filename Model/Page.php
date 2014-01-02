<?php
/**
 * Page model
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
 * Class Page
 *
 * @property User $User
 */
class Page extends AppModel
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
    public $actsAs = ['Tree', 'Containable'];

    /**
     * Custom database table name, or null/false if no table association is desired.
     *
     * @var string
     */
    public $useTable = 'posts';

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
            'dependent' => false
        ],
    ];

    /**
     * Get page.
     *
     * @param int   $pageId Page id
     * @param array $query  Query options
     *
     * @return array
     */
    public function getPage($pageId, array $query = [])
    {
        $defaultQuery = [
            "conditions" => ['Page.id' => $pageId, 'Page.type' => 'page'],
            "recursive" => -1
        ];

        $findQuery = Hash::merge($defaultQuery, $query);

        $page = $this->find(
            'first',
            $findQuery
        );

        return $page;
    }

    /**
     * Count all pages.
     *
     * @param string $status Page status
     *
     * @return intiger Number of all pages in specify status.
     */
    public function countPages($status = 'all')
    {
        switch ($status) {
            case 'all':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Page.status' => array('publish', 'draft'),
                            'Page.type' => 'page'
                        )
                    )
                );
                break;

            case 'publish':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Page.status' => 'publish',
                            'Page.type' => 'page'
                        )
                    )
                );
                break;

            case 'draft':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Page.status' => 'draft',
                            'Page.type' => 'page'
                        )
                    )
                );
                break;

            case 'trash':
                $num = $this->find(
                    'count',
                    array(
                        'conditions' => array(
                            'Page.status' => 'trash',
                            'Page.type' => 'page'
                        )
                    )
                );
                break;

            default:
                break;
        }

        return $num;
    }
}
