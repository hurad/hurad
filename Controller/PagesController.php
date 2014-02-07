<?php
/**
 * Pages Controller
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
App::uses('AppController', 'Controller');
App::uses('Post', 'Model');

/**
 * Class PagesController
 *
 * @property Page $Page
 */
class PagesController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the class name.
     *
     * Example: `public $helpers = array('Html', 'Js', 'Time', 'Ajax');`
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $helpers = ['Content', 'Comment', 'Text', 'Editor' => ['name' => 'data[Page][content]']];

    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     */
    public $components = ['RequestHandler', 'Hurad', 'Paginator'];

    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = [
        'Page' => [
            'conditions' => [
                'Page.status' => [Post::STATUS_PUBLISH, Post::STATUS_DRAFT, Post::STATUS_PENDING],
                'Page.type' => 'page'
            ],
            'limit' => 25,
            'order' => [
                'Page.created' => 'desc'
            ]
        ]
    ];

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'pageIndex', 'viewById');
    }

    public function pageIndex()
    {
        $pages = $this->Page->find(
            'threaded',
            array(
                'conditions' => array('Page.type' => 'page'),
                'order' => array('Page.' . $this->request->named['sort'] => $this->request->named['direction']),
            )
        );

        if (!empty($this->request->params['requested'])) {
            return $pages;
        } else {
            $this->set(compact($pages));
        }
    }

    /**
     * View page
     *
     * @param null|string $slug
     *
     * @throws NotFoundException
     */
    public function view($slug = null)
    {
        $this->Page->slug = $slug;
        if (is_null($slug) && !$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid page'));
        } else {
            $this->set('page', $this->Page->findBySlug($slug));
            $this->_fallbackView($slug);
        }
    }

    /**
     * View post filtered by post id
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
    public function viewById($id = null)
    {
        $this->Page->id = $id;
        if (is_null($id) && !$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid page'));
        }

        $this->set('page', $this->Page->read(null, $id));

        if (!$this->_fallbackView($id)) {
            $this->render('view');
        }
    }

    /**
     * List of pages
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Pages'));
        $this->Page->recursive = 0;

        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                array(
                    'Page' => array(
                        'conditions' => array(
                            'Page.title LIKE' => '%' . $q . '%',
                        )
                    )
                )
            );
        } else {
            $this->Paginator->settings = $this->paginate;
        }

        $this->set('pages', $this->Paginator->paginate('Page'));
    }

    /**
     * Add page
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Page'));
        if ($this->request->is('post')) {
            $this->request->data['Page']['created'] = $this->Hurad->dateParse($this->request->data['Page']['created']);
            $this->request->data['Page']['type'] = 'page';
            $this->request->data['Page']['user_id'] = $this->Auth->user('id');

            if (empty($this->request->data['Page']['slug'])) {
                $this->request->data['Page']['slug'] = HuradSanitize::title(
                    $this->request->data['Page']['title'],
                    'dash'
                );
            } else {
                $this->request->data['Page']['slug'] = HuradSanitize::title(
                    $this->request->data['Page']['slug'],
                    'dash'
                );
            }

            $this->Page->create();
            if ($this->Page->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The page has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The page could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
        $parentPages = $this->Page->generateTreeList(array('Page.type' => 'page'), null, null, '_');
        $this->set(compact('parentPages'));
    }

    /**
     * Edit page
     *
     * @param null|int $id
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Page'));

        if (!empty($this->request->data)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['Page']['created'] = $this->Hurad->dateParse(
                    $this->request->data['Page']['created']
                );
                $this->request->data['Page']['type'] = 'page';
                $this->request->data['Page']['user_id'] = $this->Auth->user('id');

                if (empty($this->request->data['Page']['slug'])) {
                    $this->request->data['Page']['slug'] = HuradSanitize::title(
                        $this->request->data['Page']['title'],
                        'dash'
                    );
                } else {
                    $this->request->data['Page']['slug'] = HuradSanitize::title(
                        $this->request->data['Page']['slug'],
                        'dash'
                    );
                }

                // save the data
                $this->Page->create();
                if ($this->Page->save($this->request->data)) {
                    $this->Session->setFlash(
                        __d('hurad', 'The Page has been saved.'),
                        'flash_message',
                        ['class' => 'success']
                    );
                    $this->redirect(['action' => 'index']);
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'The Page could not be saved. Please, try again.'),
                        'flash_message',
                        ['class' => 'danger']
                    );
                }
            }
        } elseif (empty($this->request->data)) {
            $this->request->data = $this->Page->read(null, $id);
        }

        $parentPages = $this->Page->generateTreeList(
            ['Page.type' => 'page', 'Page.id !=' => $id],
            null,
            null,
            '_'
        );
        $this->set(compact('parentPages'));
    }

    /**
     * Delete page
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $this->Page->id = $id;
        if (!$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid page'));
        }

        if ($this->Page->delete()) {
            $this->Session->setFlash(__d('hurad', 'Page deleted.'), 'flash_message', ['class' => 'success']);
            $this->redirect(['action' => 'index']);
        }

        $this->Session->setFlash(__d('hurad', 'Page was not deleted.'), 'flash_message', ['class' => 'danger']);
        $this->redirect(['action' => 'index']);
    }

    /**
     * List of pages filtered by author
     *
     * @param null|int $userId
     *
     * @throws NotFoundException
     */
    public function admin_listByAuthor($userId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Pages'));
        $this->Page->user_id = $userId;

        if (is_null($userId) && !$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid author'));
        }

        $this->Page->recursive = 0;
        $this->Paginator->settings = Hash::merge(
            $this->paginate,
            [
                'Page' => [
                    'conditions' => [
                        'Page.user_id' => $userId,
                    ]
                ]
            ]
        );

        $this->set('pages', $this->Paginator->paginate('Page'));
        $this->render('admin_index');
    }

    /**
     * Filter pages
     *
     * @param null|string $action
     */
    public function admin_filter($action = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Pages'));
        $this->Page->recursive = 0;

        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __d('hurad', 'Pages Published'));

                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Page' => [
                            'conditions' => [
                                'Page.status' => Post::STATUS_PUBLISH,
                            ]
                        ]
                    ]
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __d('hurad', 'Draft Pages'));

                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Page' => [
                            'conditions' => [
                                'Page.status' => Post::STATUS_DRAFT,
                            ]
                        ]
                    ]
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __d('hurad', 'Pages'));

                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Page' => [
                            'conditions' => [
                                'Page.status' => Post::STATUS_TRASH,
                            ]
                        ]
                    ]
                );
                break;
        }

        $this->set('pages', $this->Paginator->paginate('Page'));
        $this->render('admin_index');
    }

    /**
     * Specific view file
     *
     * @param string $viewName Slug or page id
     *
     * @return bool
     */
    private function _fallbackView($viewName)
    {
        if (file_exists(
            APP . 'View' . DS . 'Themed' . DS . Configure::read(
                'template'
            ) . DS . 'Pages' . DS . 'view-' . $viewName . '.ctp'
        )
        ) {
            $this->render('view-' . $viewName);
            return true;
        } else {
            return false;
        }
    }
}
