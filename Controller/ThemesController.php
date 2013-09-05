<?php

/**
 * Theme Controller
 *
 * This file is theme controller file.
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
App::uses('HuradTheme', 'Lib');

/**
 * ThemesController is used for managing Hurad themes.
 *
 * @package app.Controller
 */
class ThemesController extends AppController
{

    /**
     * uses property
     *
     * @var array
     * @access public
     */
    public $uses = array();

    /**
     * For the list of available themes.
     * admin_index action (admin/theme/index)
     *
     * @since 0.1.0
     * @access public
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Themes'));

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
     * admin_delete action (admin/theme/delete)
     *
     * @since 0.1.0
     * @access public
     *
     * @param string $alias Theme folder
     *
     * @return void
     */
    public function admin_delete($alias = null)
    {
        if ($alias == null) {
            $this->Session->setFlash(__d('hurad', 'Invalid Theme.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
        if (HuradTheme::delete($alias)) {
            $this->Session->setFlash(
                __d('hurad', '%s Theme successfuly deleted.', Configure::read('template')),
                'success'
            );
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__d('hurad', 'Occured error.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * To activate a theme.
     * admin_activate action (admin/theme/activate)
     *
     * @since 0.1.0
     * @access public
     *
     * @param string $alias Theme folder
     *
     * @return void
     */
    public function admin_activate($alias = null)
    {
        if (HuradTheme::activate($alias)) {
            $this->Session->setFlash(__d('hurad', 'Theme activated.'), 'success');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__d('hurad', 'Theme activation failed.'), 'error');
            $this->redirect(array('action' => 'index'));
        }
    }

}