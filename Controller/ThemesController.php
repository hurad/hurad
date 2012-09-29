<?php

App::uses('File', 'Utility');
App::uses('Folder', 'Utility');
App::uses('HrTheme', 'Lib');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ThemesController
 *
 * @author mohammad
 */
class ThemesController extends AppController {

    protected $_HrTheme = false;

    public function __construct($request = null, $response = null) {
        $this->_HrTheme = new HrTheme();
        parent::__construct($request, $response);
    }

    public function admin_index() {
        $this->set('title_for_layout', __('Themes'));

        $themes = $this->_HrTheme->getThemes(TRUE);
        //$themesData = array();
        $themesData = $this->_HrTheme->getData();

        foreach ($themes as $folderName => $themeName) {
            $themesData[$folderName] = $this->_HrTheme->getData($folderName);
        }
        $currentTheme = $this->_HrTheme->getData(Configure::read('template'));
        $this->set(compact('themes', 'themesData', 'currentTheme'));
    }

    public function admin_delete($alias = null) {
        if ($alias == null) {
            $this->Session->setFlash(__('Invalid Theme.'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        if ($alias == Configure::read('template')) {
            $this->Session->setFlash(__('You cannot delete a theme that is currently active.'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        $paths = array(
            APP . 'webroot' . DS . 'theme' . DS . $alias . DS,
            APP . 'View' . DS . 'Themed' . DS . $alias . DS,
        );

        $error = 0;
        $folder = & new Folder;
        foreach ($paths as $path) {
            if (is_dir($path)) {
                if (!$folder->delete($path)) {
                    $error = 1;
                }
            }
        }

        if ($error == 1) {
            $this->Session->setFlash(__('An error occurred.'), 'flash_error');
        } else {
            $this->Session->setFlash(__('Theme deleted successfully.'), 'flash_notice');
        }

        $this->redirect(array('action' => 'index'));
    }

    public function admin_activate($alias = null) {
        if ($this->_HrTheme->activate($alias)) {
            $this->Session->setFlash(__('Theme activated.'), 'default', array('class' => 'success'));
        } else {
            $this->Session->setFlash(__('Theme activation failed.'), 'default', array('class' => 'success'));
        }

        $this->redirect(array('action' => 'index'));
    }

}

?>
