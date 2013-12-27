<?php

App::uses('AppModel', 'Model');

/**
 * Page Model
 *
 * @property User $User
 */
class Page extends AppModel
{

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
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id',
        ]
    ];

    /**
     * hasMany associations
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
     * @param int $pageId Page id
     * @param array $query Query options
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
