<?php
/**
 * Widget helper
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
App::uses('AppHelper', 'View/Helper');

/**
 * Class WidgetHelper
 */
class WidgetHelper extends AppHelper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Form'];

    public function sidebar($sidebarId = null)
    {
        if (is_null($sidebarId) && !in_array($sidebarId, Configure::read('sidebars'))) {
            return false;
        }

        $sidebar_widgets = unserialize(Configure::read(Configure::read('template') . '.widgets'));
        $widgets = Configure::read('widgets');
        if (Configure::check(Configure::read('template') . '.widgets') && !is_null(
                Configure::read(Configure::read('template') . '.widgets')
            )
        ) {
            $this->_View->start($sidebarId);

            foreach ($sidebar_widgets[$sidebarId] as $widget) {
                $sidebar = Configure::read('sidebars')[$sidebarId];
                echo sprintf($sidebar['before_widget'], $widget['unique-id'], $sidebar['class']);
                echo $sidebar['before_title'];
                echo isset($widget['title']) && !empty($widget['title']) ? $widget['title'] : $widgets[$widget['widget-id']]['title'];
                echo $sidebar['after_title'];
                echo $this->_View->element(
                    'Widgets/' . $widgets[$widget['widget-id']]['element'],
                    array('data' => HuradWidget::getWidgetData($widget['unique-id']))
                );
                echo $sidebar['after_widget'];
            }

            $this->_View->end();
        }

        echo $this->_View->fetch($sidebarId);
    }

    public function label($for, $text)
    {
        $options = array(
            'class' => 'control-label'
        );
        echo $this->Form->label('Widget' . ucfirst($for) . '-id', $text, $options);
    }

    public function input($inputName, $data, $options = array())
    {
        $defaultOptions = array(
            'id' => 'Widget' . ucfirst($inputName) . '-id',
            'class' => 'form-control',
            'name' => $inputName,
            'type' => 'text',
            'label' => false,
            'div' => false
        );

        $defaultOptions = Hash::merge($defaultOptions, $options);

        if (count($data) > 0) {
            $options = array(
                'value' => $data[$inputName],
            );
        } else {
            $options = array(
                'value' => '',
            );
        }

        $options = Hash::merge($defaultOptions, $options);

        echo $this->Form->input($inputName, $options);
    }

    public function select($inputName, $data, $options, $attributes = array())
    {
        $defaultAttributes = array(
            'id' => 'Widget' . ucfirst($inputName) . '-id',
            'class' => 'form-control',
            'name' => $inputName,
            'label' => false,
            'div' => false,
            'empty' => false
        );

        if (count($data) > 0) {
            $attributes = array(
                'value' => $data[$inputName]
            );
        }

        $attributes = Hash::merge($defaultAttributes, $attributes);

        echo $this->Form->select($inputName, $options, $attributes);
    }

    public function radio($fieldName, array $data, array $options, array $attributes = [])
    {
        $defaultAttributes = [
            'id' => 'Widget' . ucfirst($fieldName) . '-id',
            'name' => $fieldName,
            'label' => false
        ];


        if (count($data) > 0) {
            $attributes['value'] = $data[$fieldName];
        }

        $attr = HuradFunctions::arraySliceAssoc($attributes, ['show-type', 'btn-class']);
        unset($attributes['show-type']);
        unset($attributes['btn-class']);
        $attributes = Hash::merge($defaultAttributes, $attributes);

        if ($attr['show-type'] == 'btn-group') {
            if (!isset($attr['btn-class'])) {
                $attr['btn-class'] = 'btn-default';
            }
            $opt[] = '<div class="btn-group" data-toggle="buttons">';
            foreach ($options as $value => $label) {
                if (isset($attributes['value']) && $value == $attributes['value']) {
                    $active = ' active';
                } else {
                    $active = '';
                }

                $opt[] = '<label class="btn ' . $attr['btn-class'] . $active . '">';
                $opt[] = $this->Form->radio($fieldName, [$value => $label], $attributes);
                $opt[] = '</label>';
            }
            $opt[] = '</div>';
        } else {
            foreach ($options as $value => $label) {
                $opt[] = '<div class="radio">';
                $opt[] = '<label>';
                $opt[] = $this->Form->radio($fieldName, [$value => $label], $attributes);
                $opt[] = '</label>';
                $opt[] = '</div>';
            }
        }

        return implode('', $opt);
    }

    public function formExist($element)
    {
        return $this->_View->elementExists('Widgets/' . $element . '-form');
    }
}
