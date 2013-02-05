<?php

App::uses('AppController', 'Controller');

/**
 * Links Controller
 *
 * @property Link $Link
 */
class LinksController extends AppController {

    public $helpers = array('AdminLayout');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        //$this->isAuthorized();
    }

    public function isAuthorized() {
        switch ($this->Auth->user('role')) {
            case 'admin':
                $this->Auth->allow('*');
                break;
            case 'user':
                $this->Auth->allow('index', 'profile', 'change_password', 'login', 'logout');
            default :
                $this->Auth->allow('login', 'logout', 'view', 'register');
                break;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Link->recursive = 0;
        $this->set('links', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        $this->set('link', $this->Link->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Link->create();
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(__('The link has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link could not be saved. Please, try again.'));
            }
        }
        $parentLinks = $this->Link->ParentLink->find('list');
        $menus = $this->Link->Menu->find('list');
        $this->set(compact('parentLinks', 'menus'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(__('The link has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Link->read(null, $id);
        }
        $parentLinks = $this->Link->ParentLink->find('list');
        $menus = $this->Link->Menu->find('list');
        $this->set(compact('parentLinks', 'menus'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        if ($this->Link->delete()) {
            $this->Session->setFlash(__('Link deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Link was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Links'));
        $this->Link->recursive = 0;
        $this->set('links', $this->paginate(array('Linkcat.type' => 'link_category')));
    }

    public function admin_indexBymenu($menu_id) {
        $this->Link->Menu->id = $menu_id;
        if (!$this->Link->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }

        $this->Link->Menu->recursive = 0;
        $menu = $this->Link->Menu->findById($menu_id);

        $this->set('title_for_layout', sprintf(__('Links: %s'), $menu['Menu']['name']));
        $this->set('links', $this->paginate('Link', array('Link.menu_id' => $menu_id)));
        $this->render('admin_index');
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        $this->set('link', $this->Link->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($menu_id = NULL) {
        if (is_null($menu_id)) {
            $this->set('title_for_layout', __('Add New Link'));
            if ($this->request->is('post')) {
                $this->Link->create();
                if ($this->Link->save($this->request->data)) {
                    $this->Session->setFlash(__('The link has been saved'), 'flash_notice');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The link could not be saved. Please, try again.'), 'flash_error');
                }
            }
            $linkcats = $this->Link->Linkcat->find('list', array(
                'conditions' => array('Linkcat.type' => 'link_category'),
                    ));
            $this->set(compact('linkcats', 'menu_id'));
        } else {
            $this->Link->Menu->id = $menu_id;
            if (!$this->Link->Menu->exists()) {
                throw new NotFoundException(__('Invaluid menu'));
            }
            $this->Link->Menu->recursive = 0;
            $menu = $this->Link->Menu->findById($menu_id);

            $this->set('title_for_layout', sprintf(__('Add New Link to: %s'), $menu['Menu']['name']));
            if ($this->request->is('post')) {
                $this->Link->create();
                if ($this->Link->save($this->request->data)) {
                    $this->Session->setFlash(__('The link has been saved', 'flash_notice'));
                    $this->redirect(array('action' => 'indexBymenu', $menu_id));
                } else {
                    $this->Session->setFlash(__('The link could not be saved. Please, try again.'), 'flash_error');
                }
            }
            $linkcats = $this->Link->Menu->find('list', array(
                'conditions' => array(
                    'Menu.id' => $menu_id
                ),
                    ));
            $this->set(compact('linkcats', 'menu_id'));
        }
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->set('title_for_layout', __('Edit Link'));
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(__('The link has been saved'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link could not be saved. Please, try again.'), 'notice');
            }
        } else {
            $this->request->data = $this->Link->read(null, $id);
            $menu_id = $this->request->data['Link']['menu_id'];
        }
        $linkcats = $this->Link->Linkcat->find('list', array(
            'conditions' => array('Linkcat.type' => 'link_category'),
                ));
        $this->set(compact('linkcats', 'menu_id'));
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
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__('Invalid link'));
        }
        if ($this->Link->delete()) {
            $this->Session->setFlash(__('Link deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Link was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = NULL;
        if ($this->request->data['Link']['action']['top']) {
            $action = $this->request->data['Link']['action']['top'];
        } elseif ($this->request->data['Link']['action']['bot']) {
            $action = $this->request->data['Link']['action']['bot'];
        }
        $ids = array();
        foreach ($this->request->data['Link'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'error');
            $this->redirect($this->referer());
        }

        switch ($action) {
            case 'delete':
                if ($this->Link->deleteAll(array('Link.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Links deleted.'), 'notice');
                }
                break;

            case 'visible':
                if ($this->Link->updateAll(array('Link.visible' => "'Y'"), array('Link.id' => $ids))) {
                    $this->Session->setFlash(__('Links visible'), 'notice');
                }
                break;

            case 'invisible':
                if ($this->Link->updateAll(array('Link.visible' => "'N'"), array('Link.id' => $ids))) {
                    $this->Session->setFlash(__('Links invisible'), 'notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }
        $this->redirect($this->referer());
    }

}
