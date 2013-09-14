<?php

/**
 * Category Controller
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
 * Class CategoriesController
 *
 * @property Category $Category
 */
class CategoriesController extends AppController
{
    public $components = array('Paginator');
    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = array(
        'Category' => array(
            'limit' => 25
        )
    );

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Session->delete('Message.auth');
        $this->Auth->allow('index');
    }

    /**
     * List of categories
     *
     * @return array
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
        }

        $this->Category->recursive = 0;
        $this->set('categories', $this->Paginator->paginate('Category'));
    }

    /**
     * List of categories
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Categories'));
        $this->Paginator->settings = Hash::merge(
            $this->paginate,
            array(
                'Category' => array(
                    'order' => array('Category.lft' => 'ASC'),
                    'contain' => false
                )
            )
        );
        $this->set('categories', $this->Paginator->paginate('Category'));
    }

    /**
     * Add category
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add New Category'));
        if ($this->request->is('post')) {
            $this->Category->create();
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
     * Edit category
     *
     * @param null|int $id
     *
     * @throws NotFoundException
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
                    array('class' => 'danger')
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
     * Delete category
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid category'));
        } elseif ($id == '1') {
            $this->Session->setFlash(
                __d('hurad', 'You could not delete Uncategorized category.'),
                'flash_message',
                array('class' => 'warning')
            );
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
                array('class' => 'danger')
            );
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Category processes
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
            $this->Session->setFlash(__d('hurad', 'No item selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                foreach ($ids as $value) {
                    $this->Category->removeFromTree($value);
                }
                $this->Session->setFlash(
                    __d('hurad', 'Categories was deleted.'),
                    'flash_message',
                    array('class' => 'success')
                );
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

}