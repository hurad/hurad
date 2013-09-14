<?php
/**
 * Plugins Controller
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
 * Class PluginsController
 */
class PluginsController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * @var array
     */
    public $uses = array();

    /**
     * List of plugins
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Plugins'));

        $plugins = HuradPlugin::getPluginData();
        $this->set(compact('plugins'));
    }

    /**
     * Active or deactivate plugins
     *
     * @param string $alias name of plugin
     */
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