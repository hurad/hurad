<?php
/**
 * Themes Controller
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
 * Class ThemesController
 */
class ThemesController extends AppController
{

    /**
     * An array containing the class names of models this controller uses.
     *
     * @var array
     */
    public $uses = array();

    /**
     * List of themes
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
     * Delete theme
     *
     * @param null|string $alias Theme directory name
     */
    public function admin_delete($alias = null)
    {
        if ($alias == null) {
            $this->Session->setFlash(__d('hurad', 'Invalid Theme.'), 'flash_message', array('class' => 'danger'));
            $this->redirect(array('action' => 'index'));
        }
        if (HuradTheme::delete($alias)) {
            $this->Session->setFlash(
                __d('hurad', '%s Theme successfully deleted.', Configure::read('template')),
                'flash_message',
                array('class' => 'success')
            );
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__d('hurad', 'Occurred error.'), 'flash_message', array('class' => 'danger'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Activate theme
     *
     * @param null|string $alias Theme directory name
     */
    public function admin_activate($alias = null)
    {
        if (HuradTheme::activate($alias)) {
            $this->Session->setFlash(__d('hurad', 'Theme activated.'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(
                __d('hurad', 'Theme activation failed.'),
                'flash_message',
                array('class' => 'danger')
            );
            $this->redirect(array('action' => 'index'));
        }
    }

}