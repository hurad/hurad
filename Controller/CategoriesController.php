<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

    public $helpers = array('Utils.Tree');
    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Category.name' => 'desc'
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
        if (!empty($this->request->params['requested'])) {
            $cats = $this->Category->find('threaded', array(
                    'order' => array('Category.' . $this->request->named['sort'] => $this->request->named['direction']),
                    //'limit' => $this->request->named['limit'],
                    )
            );
            return $cats;
        } else {
            $this->Category->recursive = 0;
            $this->set('categories', $this->paginate());
        }
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->set('category', $this->Category->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Category->ParentCategory->find('list');
        $posts = $this->Category->Post->find('list');
        $this->set(compact('parentCategories', 'posts'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Category->read(null, $id);
        }
        $parentCategories = $this->Category->ParentCategory->find('list');
        $posts = $this->Category->Post->find('list');
        $this->set(compact('parentCategories', 'posts'));
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Category deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Categories', true));

        $categories = $this->Category->find('all', array('order' => 'Category.lft ASC', 'contain' => false));
        $treelist = $this->Category->generateTreeList(null, null, null, '_');

        $i = 0;
        foreach ($treelist as $value) {
            $categories[$i]['Category']['path'] = $value;
            $i++;
        }

        $this->set(compact('categories'));
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->set('category', $this->Category->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->set('title_for_layout', __('Add New Category', true));
        if ($this->request->is('post')) {
            $this->Category->create();
            //$this->request->data['Category']['parent_id'] = $this->ModelName->getInsertID();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'));
            }
        }
        $parentCategories = $this->Category->generateTreeList();
        $posts = $this->Category->Post->find('list');
        $this->set(compact('parentCategories', 'posts'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->set('title_for_layout', __('Edit Category', true));
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'), 'flash_notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $this->Category->read(null, $id);
        }
        $parentCategories = $this->Category->generateTreeList();
        $posts = $this->Category->Post->find('list');
        $this->set(compact('parentCategories', 'posts'));
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Category->removeFromTree($id, true)) {
            $this->Session->setFlash(__('Category deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
