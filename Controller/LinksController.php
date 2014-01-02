<?php
/**
 * Links Controller
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
 * Class LinksController
 *
 * @property Link $Link
 */
class LinksController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the class name.
     *
     * Example: `public $helpers = array('Html', 'Js', 'Time', 'Ajax');`
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $helpers = ['AdminLayout'];

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
    public $paginate = array(
        'conditions' => array('Linkcat.type' => 'link_category'),
        'limit' => 25,
        'order' => array(
            'Link.created' => 'desc'
        )
    );

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    /**
     * List of links
     */
    public function index()
    {
        $this->Link->recursive = 0;
        $this->set('links', $this->Paginator->paginate('Link'));
    }

    /**
     * List of links
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Links'));
        $this->Link->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                array(
                    'Link' => array(
                        'conditions' => array(
                            'Link.name LIKE' => '%' . $q . '%',
                        )
                    )
                )
            );
        }
        $this->set('links', $this->Paginator->paginate('Link'));
    }

    /**
     * List of links by menu id
     *
     * @param int $menuId
     *
     * @throws NotFoundException
     */
    public function admin_indexByMenu($menuId)
    {
        $this->Link->Menu->id = $menuId;
        if (!$this->Link->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }

        $this->Link->Menu->recursive = 0;
        $menu = $this->Link->Menu->findById($menuId);

        $this->Paginator->settings = Hash::merge(
            $this->paginate,
            array(
                'Link' => array(
                    'conditions' => array(
                        'Link.menu_id' => $menuId,
                    )
                )
            )
        );

        $this->set('title_for_layout', sprintf(__d('hurad', 'Links: %s'), $menu['Menu']['name']));
        $this->set('links', $this->Paginator->paginate('Link'));
        $this->render('admin_index');
    }

    /**
     * Add link
     *
     * @param null|int $menuId
     *
     * @throws NotFoundException
     */
    public function admin_add($menuId = null)
    {
        if (is_null($menuId)) {
            $this->set('title_for_layout', __d('hurad', 'Add New Link'));
            if ($this->request->is('post')) {
                $this->Link->create();
                if ($this->Link->save($this->request->data)) {
                    $this->Session->setFlash(
                        __d('hurad', 'The link has been saved'),
                        'flash_message',
                        array('class' => 'success')
                    );
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'The link could not be saved. Please, try again.'),
                        'flash_message',
                        array('class' => 'danger')
                    );
                }
            }
            $linkCats = $this->Link->Linkcat->find(
                'list',
                array(
                    'conditions' => array('Linkcat.type' => 'link_category'),
                )
            );
            $this->set(compact('linkCats', 'menuId'));
        } else {
            $this->Link->Menu->id = $menuId;
            if (!$this->Link->Menu->exists()) {
                throw new NotFoundException(__d('hurad', 'Invalid menu'));
            }
            $this->Link->Menu->recursive = 0;
            $menu = $this->Link->Menu->findById($menuId);

            $this->set('title_for_layout', sprintf(__d('hurad', 'Add New Link to: %s'), $menu['Menu']['name']));
            if ($this->request->is('post')) {
                $this->Link->create();
                if ($this->Link->save($this->request->data)) {
                    $this->Session->setFlash(
                        __d('hurad', 'The link has been saved'),
                        'flash_message',
                        array('class' => 'success')
                    );
                    $this->redirect(array('action' => 'indexByMenu', $menuId));
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'The link could not be saved. Please, try again.'),
                        'flash_message',
                        array('class' => 'danger')
                    );
                }
            }
            $linkCats = $this->Link->Menu->find(
                'list',
                array(
                    'conditions' => array(
                        'Menu.id' => $menuId
                    ),
                )
            );
            $this->set(compact('linkCats', 'menuId'));
        }
    }

    /**
     * Edit link
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Link'));
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid link'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The link has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The link could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->Link->read(null, $id);
            $menuId = $this->request->data['Link']['menu_id'];
        }
        $linkCats = $this->Link->Linkcat->find(
            'list',
            array(
                'conditions' => array('Linkcat.type' => 'link_category'),
            )
        );
        $this->set(compact('linkCats', 'menuId'));
    }

    /**
     * Delete link
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
        $this->Link->id = $id;
        if (!$this->Link->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid link'));
        }
        if ($this->Link->delete()) {
            $this->Session->setFlash(__d('hurad', 'Link deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Link was not deleted'), 'flash_message', array('class' => 'danger'));
        $this->redirect(array('action' => 'index'));
    }
}
