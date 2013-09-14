<?php
/**
 * Pages Controller
 *
 * PHP 5
 *
 * @link http://hurad.org Hurad Project
 * @copyright Copyright (c) 2012-2013, Hurad (http://hurad.org)
 * @package app.Controller
 * @since Version 0.1.0
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */
App::uses('AppController', 'Controller');

/**
 * Class PagesController
 *
 * @property Page $Page
 */
class PagesController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses.
     *
     * @var array
     */
    public $helpers = array('Page', 'Comment', 'Text', 'Editor');
    /**
     * Other components utilized by CommentsController
     *
     * @var array
     */
    public $components = array('RequestHandler', 'Hurad');
    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = array(
        'conditions' => array(
            'Page.status' => array('publish', 'draft'),
            'Page.type' => 'page'
        ),
        'limit' => 25,
        'order' => array(
            'Page.created' => 'desc'
        )
    );

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }

    /**
     * List of pages
     */
    public function index()
    {
        if ($this->RequestHandler->isRss()) {
            $pages = $this->Page->find('all', array('limit' => 20, 'order' => 'Page.created DESC'));
            $this->set(compact('pages'));
        } else {
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                array(
                    'Page' => array(
                        'contain' => array('User', 'Comment'),
                        'conditions' => array(
                            'Page.status' => array('publish'),
                        ),
                    )
                )
            );
            $this->set('pages', $this->Paginator->paginate('Page'));
        }
    }

    public function pageIndex()
    {
        $pages = $this->Post->find(
            'threaded',
            array(
                'conditions' => array('Post.type' => 'page'),
                'order' => array('Post.' . $this->request->named['sort'] => $this->request->named['direction']),
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
                if (!in_array($this->request->data['Page']['status'], array('draft'))) {
                    $this->request->data['Page']['slug'] = Formatting::sanitize_title(
                        $this->request->data['Page']['title']
                    );
                } else {
                    $this->request->data['Page']['slug'] = Formatting::sanitize_title(
                        __("Draft-") . $this->request->data['Page']['title']
                    );
                }
            } else {
                $this->request->data['Page']['slug'] = Formatting::sanitize_title($this->request->data['Page']['slug']);
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
                $this->request->data['Page']['type'] = 'page';
                $this->request->data['Page']['user_id'] = $this->Auth->user('id');

                if (empty($this->request->data['Page']['slug'])) {
                    if (!in_array($this->request->data['Page']['status'], array('draft'))) {
                        $this->request->data['Page']['slug'] = Formatting::sanitize_title(
                            $this->request->data['Page']['title']
                        );
                    } else {
                        $this->request->data['Page']['slug'] = Formatting::sanitize_title(
                            __("Draft-") . $this->request->data['Page']['title']
                        );
                    }
                } else {
                    $this->request->data['Page']['slug'] = Formatting::sanitize_title(
                        $this->request->data['Page']['slug']
                    );
                }

                // save the data
                $this->Page->create();
                if ($this->Page->save($this->request->data)) {
                    $this->Session->setFlash(
                        __d('hurad', 'The Page has been saved.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'The Page could not be saved. Please, try again.'),
                        'flash_message',
                        array('class' => 'danger')
                    );
                }
            }
        } elseif (empty($this->request->data)) {
            $this->request->data = $this->Page->read(null, $id);
        }

        $parentPages = $this->Page->generateTreeList(
            array('Page.type' => 'page', 'Page.id !=' => $id),
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
            $this->Session->setFlash(__d('hurad', 'Page deleted.'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Page was not deleted.'), 'flash_message', array('class' => 'danger'));
        $this->redirect(array('action' => 'index'));
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
            array(
                'Page' => array(
                    'conditions' => array(
                        'Page.user_id' => $userId,
                    )
                )
            )
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
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __d('hurad', 'Pages Published'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    array(
                        'Page' => array(
                            'conditions' => array(
                                'Page.status' => 'publish',
                            )
                        )
                    )
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __d('hurad', 'Draft Pages'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    array(
                        'Page' => array(
                            'conditions' => array(
                                'Page.status' => 'draft',
                            )
                        )
                    )
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __d('hurad', 'Pages'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    array(
                        'Page' => array(
                            'conditions' => array(
                                'Page.status' => 'trash',
                            )
                        )
                    )
                );
                break;
        }

        $this->set('pages', $this->Paginator->paginate('Page'));
        $this->render('admin_index');
    }

    /**
     * Page processes
     */
    public function admin_process()
    {
        $this->autoRender = false;
        $action = null;
        if ($this->request->data['Page']['action']['top']) {
            $action = $this->request->data['Page']['action']['top'];
        } elseif ($this->request->data['Page']['action']['bot']) {
            $action = $this->request->data['Page']['action']['bot'];
        }
        $ids = array();
        foreach ($this->request->data['Page'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Page->deleteAll(array('Page.id' => $ids), true, true)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Posts deleted.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'publish':
                if ($this->Page->updateAll(array('Page.status' => "'publish'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Pages published'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'draft':
                if ($this->Page->updateAll(array('Page.status' => "'draft'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Pages drafted'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'trash':
                if ($this->Page->updateAll(array('Page.status' => "'trash'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Pages move to trash'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            default:
                $this->Session->setFlash(
                    __d('hurad', 'An error occurred.'),
                    'flash_message',
                    array('class' => 'danger')
                );
                break;
        }
        $this->redirect(array('action' => 'index'));
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