<?php
/**
 * Themes Controller
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
App::uses('HuradTheme', 'Lib');

/**
 * Class ThemesController
 */
class ThemesController extends AppController
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
