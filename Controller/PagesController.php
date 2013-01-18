<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PagesController extends AppController {

    public $helpers = array('Page', 'Comment', 'Text');
    public $components = array('RequestHandler');
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

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        //$this->isAuthorized();
    }

    public function isAuthorized() {
        switch ($this->Auth->user('role')) {
            case 'admin':
                $this->Auth->allow();
                break;
            case 'editor':
                $this->Auth->allow('admin_index', 'admin_add', 'admin_edit', 'index', 'view');
                break;
            case 'user':
                $this->Auth->allow('index', 'view');
                break;
            default :
                $this->Auth->allow('index', 'view');
                break;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
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

    public function pageIndex() {
        //$pages = $this->Post->generateTreeList(array('type' => 'page'));
        //debug($this->request->named['sort']);
        $pages = $this->Post->find('threaded', array(
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
     * @return void
     */
    public function view($slug = null) {
        $this->Page->slug = $slug;
//        if (!$this->Post->exists()) {
//            throw new NotFoundException(__('Invalid post'));
//        }
//        $this->set('post', $this->Post->read(null, $id));
        if (is_null($slug) && !$this->Page->exists()) {
//            $this->Session->setFlash(__('Your post not exist.'));
//            $this->redirect(array('action' => 'index'));
            throw new NotFoundException(__('Invalid page'));
        } else {
            $this->set('page', $this->Page->findBySlug($slug));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Pages'));
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
    public function admin_add() {
        $this->set('title_for_layout', __('Add Page'));
        if ($this->request->is('post')) {
            $this->request->data['Page']['type'] = 'page';
            $this->request->data['Page']['user_id'] = $this->Auth->user('id');
            $this->Page->create();
            if ($this->Page->save($this->request->data)) {
                $this->Session->setFlash(__('The page has been saved'), 'flash_notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The page could not be saved. Please, try again.'), 'flash_error');
            }
        }
        $parentPages = $this->Page->generateTreeList(array('Page.type' => 'page'), null, null, '_');
        $this->set(compact('parentPages'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->set('title_for_layout', __('Edit Page'));
        if (!empty($this->request->data)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['Page']['type'] = 'page';
                $this->request->data['Page']['user_id'] = $this->Auth->user('id');

                // save the data
                $this->Page->create();
                if ($this->Page->save($this->request->data)) {
                    $this->Session->setFlash(__('The Page has been saved.'), 'flash_notice');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Page could not be saved. Please, try again.'), 'flash_error');
                }
            }
        } elseif (empty($this->request->data)) {
            $this->request->data = $this->Page->read(null, $id);
        }

        $parentPages = $this->Page->generateTreeList(array('Page.type' => 'page'), null, null, '_');
        $this->set(compact('parentPages'));
    }

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Page->id = $id;
        if (!$this->Page->exists()) {
            throw new NotFoundException(__('Invalid page'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Page->delete()) {
            $this->Session->setFlash(__('Page deleted.'), 'flash_notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Page was not deleted.'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_filter method
     *
     * @param string $action
     * @return void
     */
    public function admin_filter($action = null) {
        $this->Page->recursive = 0;
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __('Pages Published'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'publish',
                    'Page.type' => 'page'
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __('Draft Pages'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'draft',
                    'Page.type' => 'page'
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __('Pages'));
                $this->paginate['conditions'] = array(
                    'Page.status' => 'trash',
                    'Page.type' => 'page'
                );
                break;

            default:
                $this->set('title_for_layout', __('Pages'));
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

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->request->data['Page']['action'];
        $ids = array();
        foreach ($this->request->data['Page'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Page->deleteAll(array('Page.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Posts deleted.'), 'flash_notice');
                }
                break;

            case 'publish':
                if ($this->Page->updateAll(array('Page.status' => "'publish'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__('Pages published'), 'flash_notice');
                }
                break;

            case 'draft':
                if ($this->Page->updateAll(array('Page.status' => "'draft'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__('Pages drafted'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Page->updateAll(array('Page.status' => "'trash'"), array('Page.id' => $ids))) {
                    $this->Session->setFlash(__('Pages move to trash'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
