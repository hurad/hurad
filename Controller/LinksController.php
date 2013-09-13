<?php
/**
 * Links Controller
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
 * Class LinksController
 *
 * @property Link $Link
 */
class LinksController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses.
     *
     * @var array
     */
    public $helpers = array('AdminLayout');
    /**
     * Other components utilized by CommentsController
     *
     * @var array
     */
    public $components = array('Paginator');
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
     * Called before the controller action.
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
                    $this->Session->setFlash(__d('hurad', 'The link has been saved'), 'success');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__d('hurad', 'The link could not be saved. Please, try again.'), 'error');
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
                    $this->Session->setFlash(__d('hurad', 'The link has been saved', 'success'));
                    $this->redirect(array('action' => 'indexByMenu', $menuId));
                } else {
                    $this->Session->setFlash(__d('hurad', 'The link could not be saved. Please, try again.'), 'error');
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
                $this->Session->setFlash(__d('hurad', 'The link has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The link could not be saved. Please, try again.'), 'error');
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
            $this->Session->setFlash(__d('hurad', 'Link deleted'), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Link was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Link processes
     */
    public function admin_process()
    {
        $this->autoRender = false;
        $action = null;
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
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'notice');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'notice');
            $this->redirect($this->referer());
        }

        switch ($action) {
            case 'delete':
                if ($this->Link->deleteAll(array('Link.id' => $ids), true, true)) {
                    $this->Session->setFlash(__d('hurad', 'Links deleted.'), 'success');
                }
                break;

            case 'visible':
                if ($this->Link->updateAll(array('Link.visible' => "'Y'"), array('Link.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Links visible'), 'success');
                }
                break;

            case 'invisible':
                if ($this->Link->updateAll(array('Link.visible' => "'N'"), array('Link.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Links invisible'), 'success');
                }
                break;

            default:
                $this->Session->setFlash(__d('hurad', 'An error occurred.'), 'error');
                break;
        }
        $this->redirect($this->referer());
    }

}