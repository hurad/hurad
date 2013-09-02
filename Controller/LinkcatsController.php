<?php

App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class LinkcatsController extends AppController
{

    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Linkcat.created' => 'desc'
        )
    );

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __('Link Categories'));
        $this->Linkcat->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->paginate['Linkcat']['limit'] = 25;
            $this->paginate['Linkcat']['conditions'] = array(
                'Linkcat.type' => 'link_category',
                'Linkcat.name LIKE' => '%' . $q . '%',
            );
        }
        $this->set('linkcats', $this->paginate('Linkcat', array('Linkcat.type' => 'link_category')));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __('Add New Link Category'));
        if ($this->request->is('post')) {
            $this->Linkcat->create();
            $this->request->data['Linkcat']['type'] = 'link_category';
            if ($this->Linkcat->save($this->request->data)) {
                $this->Session->setFlash(__('The link category has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link category could not be saved. Please, try again.'), 'error');
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
        $this->set('title_for_layout', __('Edit Link Category'));
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__('Invalid link category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Linkcat->save($this->request->data)) {
                $this->Session->setFlash(__('The link category has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The link category could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $this->Linkcat->read(null, $id);
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
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__('Invalid link category'));
        }
        if ($this->Linkcat->delete()) {
            $this->Session->setFlash(__('Link category deleted'), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Link category was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_process()
    {
        $this->autoRender = false;
        $action = $this->request->data['Linkcat']['action'];
        $ids = array();
        foreach ($this->request->data['Linkcat'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Linkcat->deleteAll(array('Linkcat.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Link categories deleted.'), 'success');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}