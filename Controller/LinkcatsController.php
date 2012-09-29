<?php

App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class LinkcatsController extends AppController {

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
        $this->Menu->recursive = 0;
        $this->set('menus', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $this->set('menu', $this->Menu->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__('The menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The menu could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__('The menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The menu could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
        }
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
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        if ($this->Menu->delete()) {
            $this->Session->setFlash(__('Menu deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Menu was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Link Categories', true));
        $this->Linkcat->recursive = 0;
        $this->set('linkcats', $this->paginate('Linkcat', array('Linkcat.type' => 'link_category')));
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $this->set('menu', $this->Menu->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->set('title_for_layout', __('Add New Link Category', true));
        if ($this->request->is('post')) {
            $this->Linkcat->create();
            $this->request->data['Linkcat']['type'] = 'link_category';
            if ($this->Linkcat->save($this->request->data)) {
                $this->Session->setFlash(__('The link category has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link category could not be saved. Please, try again.'), 'error');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->set('title_for_layout', __('Edit Link Category', true));
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__('Invalid link category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->linkcat->save($this->request->data)) {
                $this->Session->setFlash(__('The link category has been saved'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link category could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $this->Linkcat->read(null, $id);
        }
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
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__('Invalid link category'));
        }
        if ($this->Linkcat->delete()) {
            $this->Session->setFlash(__('Link category deleted'), 'notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Link category was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->data['Linkcat']['action'];
        $ids = array();
        foreach ($this->data['Linkcat'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Linkcat->deleteAll(array('Linkcat.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Link categories deleted.'), 'notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
