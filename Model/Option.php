<?php

App::uses('AppModel', 'Model');

/**
 * Option Model
 *
 */
class Option extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $validate = array(
        'General-admin_email' => array(
            'Rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'This email has already exist.',
            //'last' => true
            ),
            'Rule2' => array(
                'rule' => 'email',
                'message' => 'Please enter valid email.'
            )
        )
    );

    /**
     * Return a list of all settings.
     *
     * @access public
     * @return array
     */
    public function getOptions() {
        return $this->find('list', array(
                    'fields' => array('Option.name', 'Option.value'),
                    'cache' => __FUNCTION__
        ));
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
     * @param array $data
     * @return boolean
     */
    public function update($data) {
        $this->set($data);

        if ($this->validates()) {
            $list = $this->find('list', array(
                'fields' => array('Option.name', 'Option.id')
            ));

            foreach ($data as $prefix => $suffixes) {
                foreach ($suffixes as $suffix => $value) {
                    $this->id = $list[$prefix . '.' . $suffix];
                    $this->saveField('value', $value);
                }
            }

            return TRUE;
        }

        return FALSE;
    }

    public function write($name, $value) {
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
