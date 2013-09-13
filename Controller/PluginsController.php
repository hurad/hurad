<?php

App::uses('AppController', 'Controller');

/**
 * Description of PluginsController
 *
 * @todo complete phpDoc
 *
 * @author mohammad
 */
class PluginsController extends AppController
{

    public $uses = array();

    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Plugins'));

        $plugins = HuradPlugin::getPluginData();
        $this->set(compact('plugins'));
    }

    public function admin_toggle($alias)
    {
        $this->autoRender = false;
        if (HuradPlugin::isActive($alias)) {
            if (HuradPlugin::deactivate($alias)) {
                $this->Session->setFlash(__d('hurad', 'Plugin deactivate'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The plugin could not be deactivate. Please, try again.'),
                    'error'
                );
                $this->redirect(array('action' => 'index'));
            }
        } else {
            if (HuradPlugin::activate($alias)) {
                $this->Session->setFlash(__d('hurad', 'Plugin activate'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The plugin could not be activate. Please, try again.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /*
     * @todo add admin_delete method
     */
}