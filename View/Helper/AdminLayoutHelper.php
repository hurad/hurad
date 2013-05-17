<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Admin helper
 *
 * This file is consist of methods that are used in admin section. 
 *
 * PHP 5
 *
 * Hurad(tm) : Content Management System is based on CakePHP 2.2 (http://hurad.org)
 * Copyright 2012, Hurad CMS.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, Hurad.
 * @link          http://hurad.org Hurad(tm) Project
 * @package       Hurad
 * @category      Helper
 * @since         v 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class AdminLayoutHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Js');

    public function postStatus($value) {
        if ($value == 'publish') {
            $output = $this->Html->tag('span', __('Publish'), array('class' => 'label label-success'));
        } elseif ($value == 'draft') {
            $output = $this->Html->tag('span', __('Draft'), array('class' => 'label label-warning'));
        } elseif ($value == 'trash') {
            $output = $this->Html->tag('span', __('Trash'), array('class' => 'label label-important'));
        } else {
            $output = __('Unknown');
        }
        return $output;
    }

    public function linkVisible($value) {
        if ($value == 'Y') {
            $output = __('Yes');
        } elseif ($value == 'N') {
            $output = __('No');
        } else {
            $output = __('Unknown');
        }
        return $output;
    }

    public function linkUrl($url) {
        $pos = strpos($url, "http://");
        if ($pos === false) {
            $output = str_replace('https://', '', $url);
            $output = rtrim($output, '/');
        }
        $pos = strpos($url, "https://");
        if ($pos === false) {
            $output = str_replace('http://', '', $url);
            $output = rtrim($output, '/');
        }
        return $output;
    }

    public function optionAkismetKey($valid) {
        if ($valid === TRUE) {
            $output = '<p class="akismet_notice">';
            $output .= __('This key is valid.');
            $output .= '</p>';
        } elseif ($valid === FALSE) {
            $output = '<p class="akismet_error">';
            $output .= __('This key is not valid.');
            $output .= '</p>';
        }
        return $output;
    }

    public function optionTimeFormat($format, $def) {
        if ($format == $def) {
            echo 'checked="checked"';
        }
    }

    public function optionTimeCustom($format) {
        $def = array('g:i a', 'g:i A', 'H:i');
        if (!in_array($format, $def)) {
            echo 'checked="checked"';
        }
    }

    public function optionDateFormat($format, $def, $in_array = FALSE) {
        if ($format == $def && $in_array) {
            return 'checked';
        } elseif ($format == $def && !$in_array) {
            echo 'checked="checked"';
        }
    }

    public function optionDateCustom($format) {
        $def = array('F j, Y', 'Y/m/d', 'm/d/Y', 'd/m/Y');
        if (!in_array($format, $def)) {
            echo 'checked="checked"';
        }
    }

    public function check($bool) {
        if ($bool) {
            echo 'checked="checked"';
        } else {
            echo '';
        }
    }

    public function userRole($role) {
        if ($role == 'admin') {
            $output = __('Administrator');
        } elseif ($role == 'editor') {
            $output = __('Editor');
        } elseif ($role == 'author') {
            $output = __('Author');
        } elseif ($role == 'user') {
            $output = __('User');
        } else {
            $output = __('Unknown');
        }
        return $output;
    }

    public function approveLink($approved, $comment_id) {
        switch ($approved) {
            case '1':
                return $this->Html->link(__('Disapprove'), array('action' => 'action', 'disapproved', $comment_id));
                break;

            case '0':
                return $this->Html->link(__('Approve'), array('action' => 'action', 'approved', $comment_id));
                break;

            default:
                break;
        }
    }

    public function currentUser($info = 'username') {
        $cu = $this->_View->getVar('current_user');
        if (!$cu) {
            return FALSE;
        }
        switch ($info) {
            case 'username':
                if (isset($cu['User'])) {
                    return $cu['User']['username'];
                } else {
                    return $cu['username'];
                }
                break;

            case 'id':
                if (isset($cu['User'])) {
                    return $cu['User']['id'];
                } else {
                    return $cu['id'];
                }
                break;
        }
    }

    public function jsVar() {
        $hurad = array();
        $hurad['basePath'] = Router::url('/');
        $hurad['params'] = array(
            'controller' => $this->params['controller'],
            'action' => $this->params['action'],
            'pass' => $this->params['pass'],
            'named' => $this->params['named'],
        );
        if (is_array(Configure::read('Js'))) {
            $hurad = Set::merge($hurad, Configure::read('Js'));
        }
        return $this->Html->scriptBlock('var Hurad = ' . $this->Js->object($hurad) . ';');
    }

    public function adminMenus($options = array()) {
        //Absolute menu weight value
        foreach ($options as $key => $value) {
            $options[$key]['weight'] = abs($options[$key]['weight']);
        }
        $menuSorted = Set::sort($options, '{[a-z]+}.weight', 'asc');
        echo $this->Html->tag('div', null, array('id' => 'accordion2', 'class' => 'accordion'));
        foreach ($menuSorted as $value => $val) {
            echo $this->Html->tag('div', null, array('class' => 'accordion-group'));
            echo $this->Html->tag('div', null, array('class' => 'accordion-heading'));
            echo $this->Html->tag('a', null, array('class' => 'accordion-toggle', 'data-toggle' => 'collapse', 'data-parent' => '#accordion3', 'href' => '#collapse-' . $value));
            if ($val['icon-class']) {
                echo $this->Html->tag('i', null, array('class' => $val['icon-class']));
                echo '</i>';
            } elseif ($val['img']) {
                echo $this->Html->image($val['img']);
            }
            echo $this->Html->tag('b', ' ' . $val['title']);
            echo '</a>'; //a.accordion-toggle
            echo '</div>'; //div.accordion-heading

            if ($val['child'] && is_array($val['child'])) {
                //Absolute child weight value
                foreach ($val['child'] as $key => $v) {
                    $val['child'][$key]['weight'] = abs($val['child'][$key]['weight']);
                }
                $childSorted = Set::sort($val['child'], '{[a-z]+}.weight', 'asc');
                echo $this->Html->tag('div', null, array('id' => 'collapse-' . $value, 'class' => 'accordion-body collapse'));
                echo $this->Html->tag('div', null, array('class' => 'accordion-inner'));
                echo $this->Html->tag('ul', null, array('class' => 'nav nav-list'));
                foreach ($childSorted as $key => $value) {
                    echo $this->Html->tag('li', $this->Html->link($value['title'], $value['url']));
                }
                echo '</ul>'; //ul.nav .nav-list
                echo '</div>'; //div.accordion-inner
                echo '</div>'; //div.accordion-body .collapse
            }
            echo '</div>'; //div.accordion-group
        }
        echo '</div>'; //div.accordion
    }

    public function isFieldError($field, $errors) {
        if (key_exists($field, $errors)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function displayNameOptions($userID = null) {
        $user = ClassRegistry::init('User')->getUserData($userID);
        $options = array();
        $options[$user['username']] = $user['username'];
        if (!empty($user['firstname']) && !empty($user['lastname'])) {
            $options[$user['firstname'] . ' ' . $user['lastname']] = $user['firstname'] . ' ' . $user['lastname'];
            $options[$user['lastname'] . ' ' . $user['firstname']] = $user['lastname'] . ' ' . $user['firstname'];
        }
        if (!empty($user['firstname']) && empty($user['lastname'])) {
            $options[$user['firstname']] = $user['firstname'];
        }
        if (empty($user['firstname']) && !empty($user['lastname'])) {
            $options[$user['lastname']] = $user['lastname'];
        }
        if (!empty($user['nickname'])) {
            $options[$user['nickname']] = $user['nickname'];
        }
        return $options;
    }

    public function commentClass($approved = null) {
        switch ($approved) {
            case '0':
                return 'warning';

                break;

            case 'spam':
                return 'error';

                break;
        }
    }

}