<?php
/**
 * Linkcats Controller
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
 * Class LinkcatsController
 *
 * @property Linkcat $Linkcat
 */
class LinkcatsController extends AppController
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
}
