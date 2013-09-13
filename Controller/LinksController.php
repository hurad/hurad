<?php

App::uses('AppController', 'Controller');

/**
 * Links Controller
 *
 * @property Link $Link
 */
class LinksController extends AppController
{

    public $helpers = array('AdminLayout');
    /**
     * Paginate option
     *
     * @var array
     */
    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Link.created' => 'desc'
        )
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }

    /**
     * Link list
     */
    public function index()
    {
        $this->Link->recursive = 0;
        $this->set('links', $this->paginate());
    }

    /**
     * Admin link list
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Links'));
        $this->Link->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->paginate['Link']['limit'] = 25;
            $this->paginate['Link']['conditions'] = array(
                'Link.name LIKE' => '%' . $q . '%',
            );
        }
        $this->set('links', $this->paginate(array('Linkcat.type' => 'link_category')));
    }

    /**
     * Admin links list by menu id
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

        $this->set('title_for_layout', sprintf(__d('hurad', 'Links: %s'), $menu['Menu']['name']));
        $this->set('links', $this->paginate('Link', array('Link.menu_id' => $menuId)));
        $this->render('admin_index');
    }

    /**
     * Admin add link
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
     * Admin edit link
     *
     * @param null|int $id Link id
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
     * Admin delete link
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
     * Admin link process
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