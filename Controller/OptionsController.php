<?php

App::uses('AppController', 'Controller');

/**
 * Options Controller
 *
 * @property Option $Option
 */
class OptionsController extends AppController
{

    public $helpers = array('Link');

    public function admin_prefix($prefix = null)
    {
        $prefix_name = array(
            'general' => __('General'),
            'comment' => __('Comment'),
            'permalink' => __('Permalink'),
        );
        $this->set('title_for_layout', sprintf(__('%s Option'), $prefix_name[$prefix]));

        $options = $this->Option->find(
            'all',
            array(
                'conditions' => array(
                    'Option.name LIKE' => $prefix . '.%',
                ),
            )
        );

        if (count($options) == 0) {
            $this->Session->setFlash(__("Invalid Option name"), 'error');
            $this->redirect('/admin');
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Option']['site_url'] = rtrim($this->request->data['Option']['site_url'], "/");

            $opt = array();

            foreach ($this->request->data as $modelName => $optionArray) {
                foreach ($optionArray as $option => $value) {
                    $opt[Inflector::humanize($prefix) . '.' . $option] = $value;
                }
            }
            $optionData['Option'] = $opt;

            if ($this->Option->update($optionData)) {
                $this->Session->setFlash(__('Options have been updated!'), 'success');
            } else {
                $this->Session->setFlash(
                    __('Unable to update ' . $prefix . ' options.'),
                    'error-option',
                    array('errors' => $this->Option->validationErrors)
                );
            }
        } else {
            $this->request->data['Option'] = Configure::read(Inflector::humanize($prefix));
        }
        $this->set('errors', $this->Option->validationErrors);
        $this->set(compact('prefix'));
    }

}