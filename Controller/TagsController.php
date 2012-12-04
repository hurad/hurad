<?php

App::uses('AppController', 'Controller');

/**
 * Tags Controller
 *
 * @property Tag $Tag
 */
class TagsController extends AppController {

    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Tag.created' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Security->requirePost('admin_edit');
        $this->Auth->allow('*');
        //$this->isAuthorized();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Tag->recursive = 0;
        $this->set('tags', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        $this->set('tag', $this->Tag->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Tag->create();
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(__('The tag has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        }
        $posts = $this->Tag->Post->find('list');
        $this->set(compact('posts'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(__('The tag has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Tag->read(null, $id);
        }
        $posts = $this->Tag->Post->find('list');
        $this->set(compact('posts'));
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->Tag->delete()) {
            $this->Session->setFlash(__('Tag deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Tag was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Tags'));
        $this->Tag->recursive = 0;
        $this->set('tags', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        $this->set('tag', $this->Tag->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->set('title_for_layout', __('Add Tag'));
        if ($this->request->is('post')) {
            if ($this->request->data['Tag']['slug']) {
                $this->request->data['Tag']['slug'] = strtolower(Inflector::slug($this->request->data['Tag']['slug'], '-'));
            }
            $this->Tag->create();
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(__('The tag has been saved'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'), 'error');
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
        $this->set('title_for_layout', __('Edit Tag'));
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(__('The tag has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Tag->read(null, $id);
        }
        $posts = $this->Tag->Post->find('list');
        $this->set(compact('posts'));
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->Tag->delete()) {
            $this->Session->setFlash(__('Tag deleted'), 'notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Tag was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->request->data['Tag']['action'];
        $ids = array();
        foreach ($this->request->data['Tag'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        switch ($action) {
            case 'delete':
                if ($this->Tag->deleteAll(array('Tag.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Tags deleted.'), 'notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }
        
        $this->redirect(array('action' => 'index'));
    }

}

