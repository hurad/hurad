<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 */
class CategoriesController extends AppController {

    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Category.name' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->isAuthorized();
    }

    public function isAuthorized() {
        switch ($this->Auth->user('role')) {
            case 'admin':
                $this->Auth->allow();
                break;
            case 'editor':
                $this->Auth->allow('admin_index', 'admin_edit', 'admin_add');
                break;
            case 'author':
            case 'user':
                $this->Auth->allow('admin_index');
                break;
            default :
                return FALSE;
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
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Categories'));
        $this->paginate = array(
            'order' => array('Category.lft' => 'ASC'),
            'limit' => 20,
            'contain' => FALSE
        );
        $this->set('categories', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->set('title_for_layout', __('Add New Category'));
        if ($this->request->is('post')) {
            $this->Category->create();
            //$this->request->data['Category']['parent_id'] = $this->ModelName->getInsertID();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be saved. Please, try again.'), 'error');
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
        $this->set('title_for_layout', __('Edit Category'));
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
        } elseif ($id == '37') {
            $this->Session->setFlash(__('You are not deleted uncategorized Category'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Category->removeFromTree($id, true)) {
            $this->Session->setFlash(__('Category deleted'), 'flash_notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Category was not deleted'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = NULL;
        if ($this->request->data['Category']['action']['top']) {
            $action = $this->request->data['Category']['action']['top'];
        } elseif ($this->request->data['Category']['action']['bot']) {
            $action = $this->request->data['Category']['action']['bot'];
        }
        $ids = array();
        foreach ($this->request->data['Category'] AS $id => $value) {
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
                foreach ($ids as $value) {
                    $this->Category->removeFromTree($value);
                }
                // if ($this->Category->deleteAll(array('Category.id' => $ids), true, true)) {
                $this->Session->setFlash(__('Categories deleted.'), 'flash_notice');
                //}
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
