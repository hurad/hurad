<?php

App::uses('AppController', 'Controller');

/**
 * Description of PluginsController
 *
 * @author mohammad
 */
class PluginsController extends AppController {

    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function admin_index() {
        $this->set('title_for_layout', __('Plugins'));

        $plugins = HuradPlugin::getPluginData();
        $this->set(compact('plugins'));
    }

    public function admin_toggle($alias) {
        $this->autoRender = FALSE;
        if (HuradPlugin::isActive($alias)) {
            if (HuradPlugin::deactivate($alias)) {
                $this->Session->setFlash(__('Plugin deactivate'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The plugin could not be deactivate. Please, try again.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        } else {
            if (HuradPlugin::activate($alias)) {
                $this->Session->setFlash(__('Plugin activate'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The plugin could not be activate. Please, try again.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}