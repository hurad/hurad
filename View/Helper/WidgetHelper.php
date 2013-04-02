<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of WidgetHelper
 *
 * @author mohammad
 */
class WidgetHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Form');

    public function sidebar($sidebar_id = NULL) {
        if (is_null($sidebar_id) && !in_array($sidebar_id, Configure::read('sidebars'))) {
            return FALSE;
        }

        $sidebar_widgets = unserialize(Configure::read(Configure::read('template') . '.widgets'));
        $widgets = Configure::read('widgets');

        $this->_View->start($sidebar_id);

        foreach ($sidebar_widgets[$sidebar_id] as $widget) {
            //debug($widgets[$widget['widget-id']]['element']);
            echo $this->_View->element($widgets[$widget['widget-id']]['element'], array('data' => HuradWidget::getWidgetData($widget['unique-id'])));
        }

        $this->_View->end();


        echo $this->_View->fetch($sidebar_id);
    }

    public function label($for, $text) {
        echo $this->Form->label('Widget' . ucfirst($for), $text);
    }

    public function input($inputName, $data) {
        if (count($data) > 0) {
            echo $this->Form->input($inputName, array(
                'id' => $inputName,
                'class' => 'input-block-level',
                'name' => $inputName,
                'type' => 'text',
                'value' => $data[$inputName],
                'label' => FALSE,
                'div' => FALSE
                    )
            );
        } elseif (isset($inputName)) {
            echo $this->Form->input($inputName, array(
                'id' => $inputName,
                'class' => 'input-block-level',
                'name' => $inputName,
                'type' => 'text',
                'value' => '',
                'label' => FALSE,
                'div' => FALSE
                    )
            );
        } else {
            return FALSE;
        }
    }

    public function select($inputName, $data, $options) {
        if (count($data) > 0) {
            echo $this->Form->select($inputName, $options, array(
                'id' => $inputName,
                'class' => 'input-block-level',
                'name' => $inputName,
                'value' => $data[$inputName],
                'label' => FALSE,
                'div' => FALSE
                    )
            );
        } elseif (isset($inputName)) {
            echo $this->Form->select($inputName, $options, array(
                'id' => $inputName,
                'class' => 'input-block-level',
                'name' => $inputName,
                'label' => FALSE,
                'div' => FALSE
                    )
            );
        } else {
            return FALSE;
        }
    }

    public function formExist($element) {
        $themePath = $this->_View->getVar('themePath');
        return file_exists($themePath . 'Elements/' . $element . '-form.ctp');
    }

}