<?php
/**
 * Options Controller
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

/**
 * Class OptionsController
 *
 * @property Option $Option
 */
class OptionsController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses.
     *
     * @var array
     */
    public $helpers = array('Link');

    /**
     * List of options
     *
     * @param null|string $prefix
     */
    public function admin_prefix($prefix = null)
    {
        $prefix_name = array(
            'general' => __d('hurad', 'General'),
            'comment' => __d('hurad', 'Comment'),
            'permalink' => __d('hurad', 'Permalink'),
        );
        $this->set('title_for_layout', sprintf(__d('hurad', '%s Option'), $prefix_name[$prefix]));

        $options = $this->Option->find(
            'all',
            array(
                'conditions' => array(
                    'Option.name LIKE' => $prefix . '.%',
                ),
            )
        );

        if (count($options) == 0) {
            $this->Session->setFlash(__d('hurad', 'Invalid Option name'), 'error');
            /* @todo Set admin prefix config */
            $this->redirect('/admin');
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Option']['site_url'] = rtrim($this->request->data['Option']['site_url'], "/");

            $opt = array();

            foreach ($this->request->data as $optionArray) {
                foreach ($optionArray as $option => $value) {
                    $opt[Inflector::humanize($prefix) . '.' . $option] = $value;
                }
            }
            $optionData['Option'] = $opt;

            if ($this->Option->update($optionData)) {
                $this->Session->setFlash(__d('hurad', 'Options have been updated!'), 'success');
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'Unable to update ' . $prefix . ' options.'),
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