<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PagesController extends AppController
{

    public $helpers = array('Page', 'Comment', 'Text', 'Editor');
    public $components = array('RequestHandler', 'Role');
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

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->RequestHandler->isRss()) {
            $posts = $this->Page->find('all', array('limit' => 20, 'order' => 'Page.created DESC'));
            return $this->set(compact('pages'));
        } else {
            //$this->Post->recursive = 0;
            $this->paginate = array(
                'conditions' => array('Page.type' => 'page'),
                'contain' => array('User', 'Comment'),
                'order' => array(
                    'Page.created' => 'desc'
                )
            );
            $this->set('pages', $this->paginate('Page'));
        }
    }

    public function pageIndex()
    {
        //$pages = $this->Post->generateTreeList(array('type' => 'page'));
        //debug($this->request->named['sort']);
        $pages = $this->Post->find(
            'threaded',
            array(
                'conditions' => array('Post.type' => 'page'),
                'order' => array('Post.' . $this->request->named['sort'] => $this->request->named['direction']),
                //'limit' => $this->request->named['limit'],
            )
        );

        if (!empty($this->request->params['requested'])) {
//            foreach ($listpage as $id => $slug) {
//                $pages[$id]['path'] = $slug;
//                //$i++;
//            }
            //debug($pages);
            return $pages;
        } else {
            $this->set(compact($pages));
        }
    }

    /**
     * view method
     *
     * @param string $id
     *
     * @return void
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
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Pages'));
        $this->Page->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->paginate['Page']['limit'] = 25;
            $this->paginate['Page']['conditions'] = array(
                'Page.type' => 'page',
                'Page.title LIKE' => '%' . $q . '%',
            );
        }
        $this->set('pages', $this->paginate('Page'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Page'));
        if ($this->request->is('post')) {
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
                $this->Session->setFlash(__d('hurad', 'The page has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The page could not be saved. Please, try again.'), 'error');
            }
        }
        $parentPages = $this->Page->generateTreeList(array('Page.type' => 'page'), null, null, '_');
        $this->set(compact('parentPages'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     *
     * @return void
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
                    $this->Session->setFlash(__d('hurad', 'The Page has been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__d('hurad', 'The Page could not be saved. Please, try again.'), 'error');
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
     * admin_delete method
     *
     * @param string $id
     *
     * @return void
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Page->id = $id;
        if (!$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid page'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Page->delete()) {
            $this->Session->setFlash(__d('hurad', 'Page deleted.'), 'flash_notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Page was not deleted.'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_listByauthor($userId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Pages'));
        $this->Page->user_id = $userId;
        if (is_null($userId) && !$this->Page->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid author'));
        }
        $this->Page->recursive = 0;
        $this->paginate['Page']['limit'] = 25;
        $this->paginate['Page']['order'] = array('Page.created' => 'desc');
        $this->paginate['Page']['conditions'] = array(
            'Page.status' => array('publish', 'draft'),
            'Page.type' => 'page',
            'Page.user_id' => $userId,
        );
        $this->set('pages', $this->paginate());
        $this->render('admin_index');
    }

    /**
     * admin_filter method
     *
     * @param string $action
     *
     * @return void
     */
    public function admin_filter($action = null)
    {
        $this->Page->recursive = 0;
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __d('hurad', 'Pages Published'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'publish',
                    'Page.type' => 'page'
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __d('hurad', 'Draft Pages'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'draft',
                    'Page.type' => 'page'
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __d('hurad', 'Pages'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'trash',
                    'Page.type' => 'page'
                );
                break;

            default:
                $this->set('title_for_layout', __d('hurad', 'Pages'));
                $this->paginate['conditions'] = array(
                    'Page.status' => array('publish', 'draft'),
                    'Page.type' => 'page'
                );
                break;
        }

        $this->paginate['order'] = array('Page.created' => 'desc');
        $this->set('pages', $this->paginate('Page'));
        $this->render('admin_index');
    }

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
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Page->deleteAll(array('Page.id' => $ids), true, true)) {
                    $this->Session->setFlash(__d('hurad', 'Posts deleted.'), 'flash_notice');
                }
                break;

            case 'publish':
                if ($this->Page->updateAll(array('Page.status' => "'publish'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Pages published'), 'flash_notice');
                }
                break;

            case 'draft':
                if ($this->Page->updateAll(array('Page.status' => "'draft'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Pages drafted'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Page->updateAll(array('Page.status' => "'trash'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Pages move to trash'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__d('hurad', 'An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

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
        }
    }

}