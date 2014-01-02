<?php
/**
 * Category Controller
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('AppController', 'Controller');

/**
 * Class CategoriesController
 *
 * @property Category $Category
 */
class CategoriesController extends AppController
{
    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = [
        'Category' => [
            'limit' => 25
        ]
    ];

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
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
}
