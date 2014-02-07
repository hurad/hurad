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

    /**
     * Delete plugin
     *
     * @param string $alias Name of plugin
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function admin_delete($alias)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if (!array_key_exists($alias, HuradPlugin::getPluginData())) {
            throw new NotFoundException(__d('hurad', 'Plugin not exist'));
        }

        if (HuradPlugin::isActive($alias)) {
            throw new MethodNotAllowedException();
        }

        $output = HuradPlugin::delete($alias);

        if ($output === true) {
            $this->Session->setFlash(__d('hurad', 'Plugin deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(
                __d('hurad', '<b>Occurred error:</b><br>') . implode('<br>', $output),
                'flash_message',
                array('class' => 'danger')
            );
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Install action
     */
    public function admin_install()
    {
        $this->set('title_for_layout', __d('hurad', 'Add New Plugin'));

        if ($this->request->is('post')) {
            $upload = $this->request->data['Plugins']['plugin'];

            if ($upload['error']) {
                $this->Session->setFlash(
                    __d('hurad', 'File could not be uploaded. Please, try again.'),
                    'flash_message',
                    ['class' => 'danger']
                );
                $this->redirect(['action' => 'install']);
            }

            $folder = new Folder(__DIR__ . DS . '../tmp' . DS);

            if (!is_writable($folder->pwd())) {
                $this->Session->setFlash(
                    __d('hurad', '%s is not writable', $folder->pwd()),
                    'flash_message',
                    ['class' => 'danger']
                );
                $this->redirect(['action' => 'install']);
            }

            if ($upload['type'] != 'application/zip') {
                $this->Session->setFlash(
                    __d('hurad', 'Just plugin with .zip extension is allowed.'),
                    'flash_message',
                    ['class' => 'danger']
                );
                $this->redirect(['action' => 'install']);
            }

            $zipHandler = new ZipArchive();

            if (($res = $zipHandler->open($upload['tmp_name'])) !== true) {
                $this->Session->setFlash(
                    __d('hurad', 'Zip extraction failed with error: ' . $zipHandler->getStatusString()),
                    'flash_message',
                    ['class' => 'danger']
                );
                $this->redirect(['action' => 'install']);
            }

            if ($zipHandler->extractTo(__DIR__ . DS . '../Plugin' . DS)) {
                $zipHandler->close();
                $this->Session->setFlash(
                    __d('hurad', 'Plugin installed successfully.'),
                    'flash_message',
                    ['class' => 'success']
                );
                $this->redirect(['action' => 'install']);
            }
            $zipHandler->close();
            $this->Session->setFlash(
                __d('hurad', 'Plugin installation failed!'),
                'flash_message',
                ['class' => 'danger']
            );

            $this->redirect(['action' => 'install']);
        }
    }
}