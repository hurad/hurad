<?php

/**
 * Description of PluginsController
 *
 * @author mohammad
 */
class PluginsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->_HrPlugin = new HrPlugin();
    }

    public function admin_index() {
        $this->set('title_for_layout', __('Plugins'));

        $pluginAliases = $this->_HrPlugin->getPlugins();
        $plugins = array();
        foreach ($pluginAliases as $pluginAlias) {
            $plugins[$pluginAlias] = $this->_HrPlugin->getData($pluginAlias);
        }
        $this->set(compact('plugins'));
    }

    public function admin_toggle($plugin = null) {
        if (!$plugin) {
            $this->Session->setFlash(__('Invalid plugin'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        if ($this->_HrPlugin->isActive($plugin)) {
            $result = $this->_HrPlugin->deactivate($plugin);
            if ($result === true) {
                $this->Session->setFlash(__('Plugin "%s" deactivated successfully.', $plugin), 'flash_notice');
            } elseif (is_string($result)) {
                $this->Session->setFlash($result, 'flash_error');
            } else {
                $this->Session->setFlash(__('Plugin could not be deactivated. Please, try again.'), 'flash_error');
            }
        } else {
            $result = $this->_HrPlugin->activate($plugin);
            if ($result === true) {
                $this->Session->setFlash(__('Plugin "%s" activated successfully.', $plugin), 'flash_notice');
            } elseif (is_string($result)) {
                $this->Session->setFlash($result, 'flash_error');
            } else {
                $this->Session->setFlash(__('Plugin could not be activated. Please, try again.'), 'flash_error');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}

