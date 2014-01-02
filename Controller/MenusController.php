<?php
/**
 * Menus Controller
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
 * Class MenusController
 *
 * @property Menu $Menu
 */
class MenusController extends AppController
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
        'Menu' => [
            'conditions' => [
                'Menu.type' => 'nav_menu'
            ],
            'limit' => 25,
            'order' => [
                'Menu.created' => 'desc'
            ]
        ]
    ];

    /**
     * List of menus
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Menus'));
        $this->Menu->recursive = 0;
        $this->set('menus', $this->Paginator->paginate('Menu'));
    }

    /**
     * Add menu
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Menu'));
        if ($this->request->is('post')) {
            $this->request->data['Menu']['type'] = 'nav_menu';
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The menu has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The menu could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * Edit menu
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Menu'));
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The menu has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The menu could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
        }
    }

    /**
     * Delete menu
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
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        if ($this->Menu->delete()) {
            $this->Session->setFlash(__d('hurad', 'Menu deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Menu was not deleted'), 'flash_message', array('class' => 'danger'));
        $this->redirect(array('action' => 'index'));
    }

}