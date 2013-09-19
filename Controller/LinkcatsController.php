<?php
/**
 * Linkcats Controller
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
 * Class LinkcatsController
 *
 * @property Linkcat $Linkcat
 */
class LinkcatsController extends AppController
{
    /**
     * Other components utilized by LinkcatsController
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
        'Linkcat' => array(
            'order' => array(
                'Linkcat.created' => 'desc'
            ),
            'conditions' => array('Linkcat.type' => 'link_category'),
            'limit' => 25
        )
    );

    /**
     * List of link categories
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Link Categories'));
        $this->Linkcat->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                array(
                    'Linkcat' => array(
                        'conditions' => array('Linkcat.name LIKE' => '%' . $q . '%'),
                    )
                )
            );
        }
        $this->set('linkcats', $this->Paginator->paginate('Linkcat'));
    }

    /**
     * Add link categories
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add New Link Category'));
        if ($this->request->is('post')) {
            $this->Linkcat->create();
            $this->request->data['Linkcat']['type'] = 'link_category';
            if ($this->Linkcat->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The link category has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The link category could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * Edit link category
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Link Category'));
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid link category'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Linkcat->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The link category has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The link category could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->Linkcat->read(null, $id);
        }
    }

    /**
     * Delete link category
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
        $this->Linkcat->id = $id;
        if (!$this->Linkcat->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid link category'));
        }
        if ($this->Linkcat->delete()) {
            $this->Session->setFlash(
                __d('hurad', 'Link category deleted'),
                'flash_message',
                array('class' => 'success')
            );
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(
            __d('hurad', 'Link category was not deleted'),
            'flash_message',
            array('class' => 'danger')
        );
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Link categories processes
     */
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
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Linkcat->deleteAll(array('Linkcat.id' => $ids), true, true)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Link categories deleted.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
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