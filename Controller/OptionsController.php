<?php

App::uses('AppController', 'Controller');

/**
 * Options Controller
 *
 * @property Option $Option
 */
class OptionsController extends AppController {

    public $helpers = array('Link');
    public $components = array('Akismet');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        //$this->isAuthorized();
        $this->set('isKeyValid', $this->Akismet->isKeyValid());
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Option->recursive = 0;
        $this->set('options', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        $this->set('option', $this->Option->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Option->create();
            if ($this->Option->save($this->request->data)) {
                $this->Session->setFlash(__('The option has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The option could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Option->save($this->request->data)) {
                $this->Session->setFlash(__('The option has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The option could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Option->read(null, $id);
        }
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        if ($this->Option->delete()) {
            $this->Session->setFlash(__('Option deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Option was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Option->recursive = 0;
        $this->set('options', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        $this->set('option', $this->Option->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Option->create();
            if ($this->Option->save($this->request->data)) {
                $this->Session->setFlash(__('The option has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The option could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Option->save($this->request->data)) {
                $this->Session->setFlash(__('The option has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The option could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Option->read(null, $id);
        }
    }

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Option->id = $id;
        if (!$this->Option->exists()) {
            throw new NotFoundException(__('Invalid option'));
        }
        if ($this->Option->delete()) {
            $this->Session->setFlash(__('Option deleted'), 'notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Option was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_prefix($prefix = null) {
        $prefix_name = array(
            'general' => __('General'),
            'comment' => __('Comment'),
            'permalink' => __('Permalink'),
            );
        $this->set('title_for_layout', sprintf(__('%s Option'), $prefix_name[$prefix]));

        $options = $this->Option->find('all', array(
            'conditions' => array(
                'Option.name LIKE' => $prefix . '-%',
            ),
                ));
        //'conditions' => "Option.name LIKE '".$prefix."%'"));
        if (count($options) == 0) {
            $prefix = 'general';
            $this->Session->setFlash(__("Invalid Option name"), 'flash_error');
            $this->redirect(array('admin' => TRUE, 'controller' => 'options', 'action' => 'prefix', $prefix));
        }
        if (!empty($this->request->data)) {
            if ($this->Option->update($this->request->data)) {
                $this->Session->setFlash(__('Options have been updated!'), 'flash_notice');
                //Cache::delete('Option.getOptions');
                //Configure::write($prefix, $this->request->data['Option']);
            }  else {
                $this->Session->setFlash(__('Unable to update '.$prefix.' options.'), 'flash_error');
            }
        } else {
            $this->request->data['Option'] = $this->options;
        }
        $this->set(compact('prefix'));
    }

}
