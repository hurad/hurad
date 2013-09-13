<?php

/**
 * Category Controller
 *
 * This file is category controller file.
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
 * CategoriesController is used for managing Hurad categories.
 *
 * @package app.Controller
 * @property Category $Category
 */
class CategoriesController extends AppController
{

    public $paginate = array(
        'limit' => 5,
        'order' => array(
            'Category.name' => 'desc'
        )
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Session->delete('Message.auth');
        $this->Auth->allow('index');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->autoRender = false;
        if (!empty($this->request->params['requested'])) {
            $cats = $this->Category->find(
                'threaded',
                array(
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
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Categories'));
        $this->paginate = array(
            'order' => array('Category.lft' => 'ASC'),
            'limit' => 20,
            'contain' => false
        );
        $this->set('categories', $this->paginate());
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add New Category'));
        if ($this->request->is('post')) {
            $this->Category->create();
            //$this->request->data['Category']['parent_id'] = $this->ModelName->getInsertID();
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The category has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The category could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
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
     *
     * @throws NotFoundException
     * @return void
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Category'));
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The category has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The category could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'error')
                );
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
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @return void
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid category'));
        } elseif ($id == '1') {
            $this->Session->setFlash(__d('hurad', 'You could not delete Uncategorized category.'), 'flash_message');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Category->removeFromTree($id, true)) {
            $this->Session->setFlash(
                __d('hurad', 'Category was deleted'),
                'flash_message',
                array('class' => 'success')
            );
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(
                __d('hurad', 'Category was not deleted'),
                'flash_message',
                array('class' => 'error')
            );
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * admin_process method
     */
    public function admin_process()
    {
        $this->autoRender = false;
        $action = null;
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
            $this->Session->setFlash(__d('hurad', 'No item selected.'), 'flash_message');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                foreach ($ids as $value) {
                    $this->Category->removeFromTree($value);
                }
                // if ($this->Category->deleteAll(array('Category.id' => $ids), true, true)) {
                $this->Session->setFlash(
                    __d('hurad', 'Categories was deleted.'),
                    'flash_message',
                    array('class' => 'success')
                );
                //}
                break;

            default:
                $this->Session->setFlash(
                    __d('hurad', 'An error occurred.'),
                    'flash_message',
                    array('class' => 'error')
                );
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}