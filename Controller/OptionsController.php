<?php

App::uses('AppController', 'Controller');

/**
 * Options Controller
 *
 * @property Option $Option
 */
class OptionsController extends AppController {

    public $helpers = array('Link');
    public $components = array('Akismet');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        //$this->isAuthorized();
        $this->set('isKeyValid', $this->Akismet->isKeyValid());
    }

    public function admin_prefix($prefix = null) {
        $prefix_name = array(
            'general' => __('General'),
            'comment' => __('Comment'),
            'permalink' => __('Permalink'),
        );
        $this->set('title_for_layout', sprintf(__('%s Option'), $prefix_name[$prefix]));

        $options = $this->Option->find('all', array(
            'conditions' => array(
                'Option.name LIKE' => $prefix . '-%',
            ),
        ));
        //'conditions' => "Option.name LIKE '".$prefix."%'"));
        if (count($options) == 0) {
            $prefix = 'general';
            $this->Session->setFlash(__("Invalid Option name"), 'flash_error');
            $this->redirect(array('admin' => TRUE, 'controller' => 'options', 'action' => 'prefix', $prefix));
        }
        if (!empty($this->request->data)) {
            if ($this->Option->update($this->request->data)) {
                $this->Session->setFlash(__('Options have been updated!'), 'success');
                //Cache::delete('Option.getOptions');
                //Configure::write($prefix, $this->request->data['Option']);
            } else {
                $this->Session->setFlash(__('Unable to update ' . $prefix . ' options.'), 'error');
            }
        } else {
            $this->request->data['Option'] = $this->options;
        }
        $this->set(compact('prefix'));
    }

}