<?php

App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController
{

    public $paginate = array(
        'conditions' => array(
            'Menu.type' => 'nav_menu'
        ),
        'limit' => 25,
        'order' => array(
            'Menu.created' => 'desc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Menu->recursive = 0;
        $this->set('menus', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     *
     * @return void
     */
    public function view($id = null)
    {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        $this->set('menu', $this->Menu->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__d('hurad', 'The menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The menu could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     *
     * @return void
     */
    public function edit($id = null)
    {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__d('hurad', 'The menu has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The menu could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
        }
    }

    /**
     * delete method
     *
     * @param string $id
     *
     * @return void
     */
    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        if ($this->Menu->delete()) {
            $this->Session->setFlash(__d('hurad', 'Menu deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Menu was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Menus'));
        $this->Menu->recursive = 0;
        $this->set('menus', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @param string $id
     *
     * @return void
     */
    public function admin_view($id = null)
    {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid menu'));
        }
        $this->set('menu', $this->Menu->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Menu'));
        if ($this->request->is('post')) {
            $this->request->data['Menu']['type'] = 'nav_menu';
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__d('hurad', 'The menu has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The menu could not be saved. Please, try again.'), 'error');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @param string $id
     *
     * @return void
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
                $this->Session->setFlash(__d('hurad', 'The menu has been saved'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The menu could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
        }
    }

    /**
     * admin_delete method
     *
     * @param string $id
     *
     * @return void
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
            $this->Session->setFlash(__d('hurad', 'Menu deleted'), 'notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Menu was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

}
