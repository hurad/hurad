<?php

/**
 * Theme Controller
 *
 * This file is theme controller file.
 *
 * PHP 5
 *
 * @copyright Copyright (c) 2012-1013, Hurad (http://hurad.org)
 * @link http://hurad.org Hurad Project
 * @package app.Controller
 * @since Version 0.1.0
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */
App::uses('HuradTheme', 'Lib');

class ThemesController extends AppController {

    /**
     * uses property
     * 
     * @var array
     * @access public
     */
    public $uses = array();

    /**
     * Called before the theme controller action.
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return void
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    /**
     * For the list of available themes.
     * 
     * admin_index action (admin/theme/index)
     * 
     * @since 0.1.0
     * @access public
     * 
     * @return void 
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Themes'));

        $currentTheme = array();
        $themes = HuradTheme::getThemeData();
        $current = Configure::read('template');

        if (Configure::check('template') && !empty($current)) {
            $currentTheme = $themes[Configure::read('template')];
        }

        $this->set(compact('themes', 'currentTheme'));
    }

    /**
     * To uninstall a theme.
     * 
     * admin_delete action (admin/theme/delete)
     * 
     * @since 0.1.0
     * @access public
     * 
     * @param string $alias Theme folder
     * @return void 
     */
    public function admin_delete($alias = null) {
        if ($alias == null) {
            $this->Session->setFlash(__('Invalid Theme.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
        if (HuradTheme::delete($alias)) {
            $this->Session->setFlash(__('%s Theme successfuly deleted.', Configure::read('template')), 'success');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Occured error.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * To activate a theme.
     * 
     * admin_activate action (admin/theme/activate)
     * 
     * @since 0.1.0
     * @access public
     * 
     * @param string $alias Theme folder
     * @return void 
     */
    public function admin_activate($alias = null) {
        if (HuradTheme::activate($alias)) {
            $this->Session->setFlash(__('Theme activated.'), 'success');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Theme activation failed.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
    }

}