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
class AdminLayoutHelper extends AppHelper
{

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Js', 'Form', 'Role', 'Post', 'Page');

    public function postStatus($value)
    {
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

    public function linkVisible($value)
    {
        if ($value == 'Y') {
            $output = __('Yes');
        } elseif ($value == 'N') {
            $output = __('No');
        } else {
            $output = __('Unknown');
        }
        return $output;
    }

    public function linkUrl($url)
    {
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

    public function optionAkismetKey($valid)
    {
        if ($valid === true) {
            $output = '<p class="akismet_notice">';
            $output .= __('This key is valid.');
            $output .= '</p>';
        } elseif ($valid === false) {
            $output = '<p class="akismet_error">';
            $output .= __('This key is not valid.');
            $output .= '</p>';
        }
        return $output;
    }

    public function optionTimeFormat($format, $def)
    {
        if ($format == $def) {
            echo 'checked="checked"';
        }
    }

    public function optionTimeCustom($format)
    {
        $def = array('g:i a', 'g:i A', 'H:i');
        if (!in_array($format, $def)) {
            echo 'checked="checked"';
        }
    }

    public function optionDateFormat($format, $def, $in_array = false)
    {
        if ($format == $def && $in_array) {
            return 'checked';
        } elseif ($format == $def && !$in_array) {
            echo 'checked="checked"';
        }
    }

    public function optionDateCustom($format)
    {
        $def = array('F j, Y', 'Y/m/d', 'm/d/Y', 'd/m/Y');
        if (!in_array($format, $def)) {
            echo 'checked="checked"';
        }
    }

    public function check($bool)
    {
        if ($bool) {
            echo 'checked="checked"';
        } else {
            echo '';
        }
    }

    public function userRole($role)
    {
        switch ($role) {
            case "administrator":
                return __('Administrator');
                break;
            case "editor":
                return __('Editor');
                break;
            case "author":
                return __('Author');
                break;
            case "user":
                return __('User');
                break;
        }
    }

    public function approveLink($approved, $comment_id)
    {
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

    public function currentUser($info = 'username')
    {
        $cu = $this->_View->get('current_user');
        if (!$cu) {
            return false;
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

    public function jsVar()
    {
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

    public function adminMenus($options = array())
    {
        echo $this->Html->tag('div', null, array('id' => 'accordion2', 'class' => 'accordion'));
        foreach ($options as $value => $val) {
            if ($this->Role->currentUserCan($val['capability'])) {
                echo $this->Html->tag('div', null, array('class' => 'accordion-group'));
                echo $this->Html->tag('div', null, array('class' => 'accordion-heading'));
                echo $this->Html->tag(
                    'a',
                    null,
                    array(
                        'class' => 'accordion-toggle',
                        'data-toggle' => 'collapse',
                        'data-parent' => '#accordion3',
                        'href' => '#collapse-' . $value
                    )
                );

                if ($val['icon']['class']) {
                    echo $this->Html->tag('i', null, array('class' => $val['icon']['class']));
                    echo '</i>';
                } elseif ($val['icon']['url']) {
                    echo $this->Html->image($val['icon']['url']);
                }
                echo $this->Html->tag('b', ' ' . $val['title']);
                echo '</a>'; //a.accordion-toggle
                echo '</div>'; //div.accordion-heading

                if (isset($val['sub_menus']) && is_array($val['sub_menus'])) {
                    echo $this->Html->tag(
                        'div',
                        null,
                        array('id' => 'collapse-' . $value, 'class' => 'accordion-body collapse')
                    );
                    echo $this->Html->tag('div', null, array('class' => 'accordion-inner'));
                    echo $this->Html->tag('ul', null, array('class' => 'nav nav-list'));
                    foreach ($val['sub_menus'] as $key => $value) {
                        if ($this->Role->currentUserCan($value['capability'])) {
                            echo $this->Html->tag('li', $this->Html->link($value['title'], $value['url']));
                        }
                    }
                    echo '</ul>'; //ul.nav .nav-list
                    echo '</div>'; //div.accordion-inner
                    echo '</div>'; //div.accordion-body .collapse
                }
                echo '</div>'; //div.accordion-group
            }
        }
        echo '</div>'; //div.accordion
    }

    public function isFieldError($field, $errors)
    {
        if (key_exists($field, $errors)) {
            return true;
        } else {
            return false;
        }
    }

    public function displayNameOptions($userID = null)
    {
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

    public function commentClass($approved = null)
    {
        switch ($approved) {
            case '0':
                return 'warning';

                break;

            case 'spam':
                return 'error';

                break;
        }
    }

    public function rowActions($actions)
    {
        $links = array();
        foreach ($actions as $i => $action) {
            if ($this->Role->currentUserCan($action['capability'])) {
                if (!isset($action['options']['wrap'])) {
                    $action['options']['wrap'] = 'span';
                }

                if (!isset($action['options']['class'])) {
                    $action['options']['class'] = 'action-' . $i;
                }
                $links[] = $this->Html->tag(
                    $action['options']['wrap'],
                    $action['link'],
                    array('class' => $action['options']['class'])
                );
            }
        }
        echo implode(" | ", $links);
    }

}