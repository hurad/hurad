<?php

App::uses('HuradTheme', 'Lib');

/**
 * Description of ThemesController
 *
 * @author mohammad
 */
class ThemesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

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