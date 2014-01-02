<?php
/**
 * Plugins Controller
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
 * Class PluginsController
 */
class PluginsController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * Example: `public $uses = array('Product', 'Post', 'Comment');`
     *
     * Can be set to several values to express different options:
     *
     * - `true` Use the default inflected model name.
     * - `array()` Use only models defined in the parent class.
     * - `false` Use no models at all, do not merge with parent class either.
     * - `array('Post', 'Comment')` Use only the Post and Comment models. Models
     *   Will also be merged with the parent class.
     *
     * The default value is `true`.
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $uses = [];

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
                $this->Session->setFlash(
                    __d('hurad', 'Plugin deactivate'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The plugin could not be deactivate. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
                $this->redirect(array('action' => 'index'));
            }
        } else {
            if (HuradPlugin::activate($alias)) {
                $this->Session->setFlash(__d('hurad', 'Plugin activate'), 'flash_message', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The plugin could not be activate. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /*
     * @todo add admin_delete method
     */
}