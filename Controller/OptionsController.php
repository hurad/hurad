<?php
/**
 * Options Controller
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

/**
 * Class OptionsController
 *
 * @property Option $Option
 */
class OptionsController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the class name.
     *
     * Example: `public $helpers = array('Html', 'Js', 'Time', 'Ajax');`
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $helpers = ['Link'];

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
            $this->Session->setFlash(__d('hurad', 'Invalid Option name'), 'flash_message', array('class' => 'danger'));
            /* @todo Set admin prefix config */
            $this->redirect('/admin');
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            switch ($this->request->param('pass')[0]) {
                case'general':
                    $this->request->data['Option']['site_url'] = rtrim($this->request->data['Option']['site_url'], "/");
                    break;
            }

            $opt = array();

            foreach ($this->request->data as $optionArray) {
                foreach ($optionArray as $option => $value) {
                    $opt[Inflector::humanize($prefix) . '.' . $option] = $value;
                }
            }
            $optionData['Option'] = $opt;

            if ($this->Option->update($optionData)) {
                $this->Session->setFlash(
                    __d('hurad', 'Options have been updated!'),
                    'flash_message',
                    array('class' => 'success')
                );
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
