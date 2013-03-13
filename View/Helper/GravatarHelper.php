<?php

/**
 * Gravatar Helper
 *
 * @copyright Copyright 2009-2010, Graham Weldon (http://grahamweldon.com)
 */
class GravatarHelper extends AppHelper {

    var $helpers = array('Html');

    /**
     * Default settings
     *
     * @var array
     */
    private $__default = array('default' => null, 'size' => 96, 'rating' => null);

    /**
     * Collection of allowed ratings
     *
     * @var array
     */
    private $__rating = array('g', 'pg', 'r', 'x');

    /**
     * Default Avatars sets
     *
     * @var array
     */
    private $__defaultAvatars = array('none', 'identicon', 'mm', 'monsterid', 'retro', 'wavatar', '404');

    public function image($email, $options = array(), $alt = 'Avatar') {
        if (!empty($email)) {
            $email = md5(strtolower(trim($email)));
        } else {
            return FALSE;
        }

        return $this->Html->image('http://www.gravatar.com/avatar/' . $email . $this->_buildOptions($this->_cleanOptions($options)) . '', array(
                    'alt' => $alt,
                    'height' => $options['size'],
                    'width' => $options['size'],
                    'class' => 'avatar avatar-' . $options['size'] . ' photo')
        );
    }

    private function _buildOptions($options = array()) {
        $gravatarOptions = array_intersect(array_keys($options), array_keys($this->__default));
        if (!empty($gravatarOptions)) {
            $optionArray = array();
            foreach ($gravatarOptions as $key) {
                $value = $options[$key];
                $optionArray[] = $key . '=' . mb_strtolower($value);
            }
            return '?' . implode('&amp;', $optionArray);
        }
        return '';
    }

    private function _cleanOptions($options) {
        if (!isset($options['size']) || empty($options['size']) || !is_numeric($options['size'])) {
            unset($options['size']);
        } else {
            $options['size'] = min(max($options['size'], 1), 512);
        }

        if (!isset($options['rating']) || !in_array(strtolower($options['rating']), $this->__rating)) {
            unset($options['rating']);
        } else {
            $options['rating'] = 'g';
        }

        if (!isset($options['default']) || !in_array(strtolower($options['default']), $this->__defaultAvatars)) {
            unset($options['default']);
        }
        return $options;
    }

}

?>