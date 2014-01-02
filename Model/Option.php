<?php
/**
 * Option model
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
App::uses('AppModel', 'Model');

/**
 * Class Option
 */
class Option extends AppModel
{
    /**
     * Custom display field name. Display fields are used by Scaffold, in SELECT boxes' OPTION elements.
     *
     * This field is also used in `find('list')` when called with no extra parameters in the fields list
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'General.admin_email' => [
            'email' => [
                'rule' => 'email',
                'message' => 'Please enter valid email'
            ],
            'notEmpty' => [
                'rule' => 'notEmpty',
                'message' => 'Please not blank this field'
            ]
        ],
        'General.site_url' => [
            'url' => [
                'rule' => 'url',
                'message' => 'Please enter valid url'
            ],
        ]
    ];

    /**
     * Return a list of all settings.
     *
     * @access public
     * @return array
     */
    public function getOptions()
    {
        return $this->find(
            'list',
            array(
                'fields' => array('Option.name', 'Option.value'),
                'cache' => __FUNCTION__
            )
        );
    }

    /**
     * Update all the options.
     *
     * input array $data
     * <code>
     * $data = array(
     *      'Comment' => array(
     *          'show_avatars' => '0',
     *          'avatar_rating' => 'X',
     *          'avatar_default' => 'monsterid'
     *      )
     * )
     * </code>
     *
     * @access public
     *
     * @param array $data
     *
     * @return boolean
     */
    public function update($data)
    {
        $this->set($data);

        if ($this->validates()) {
            $list = $this->find(
                'list',
                array(
                    'fields' => array('Option.name', 'Option.id')
                )
            );

            foreach ($data as $modelName => $options) {
                foreach ($options as $name => $value) {
                    $this->id = $list[$name];
                    $this->saveField('value', $value);
                }
            }

            return true;
        }

        return false;
    }

    public function write($name, $value)
    {
        $option = $this->findByName($name);
        if (isset($option['Option']['id'])) {
            $option['Option']['id'] = $option['Option']['id'];
            $option['Option']['value'] = $value;
        } else {

            //$setting = array();
            $option['name'] = $name;
            $option['value'] = $value;
        }

        $this->id = false;
        if ($this->save($option)) {
            Configure::write($name, $value);
            return true;
        } else {
            return false;
        }
    }
}
