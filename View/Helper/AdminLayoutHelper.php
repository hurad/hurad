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
    public $helpers = array('Html');

    public function postStatus($value) {
        if ($value == 'publish') {
            $output = __('Publish');
        } elseif ($value == 'draft') {
            $output = __('Draft');
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

    public function optionDateFormat($format, $def) {
        if ($format == $def) {
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
                return $this->Html->link(__('Disapprove'), array('action' => 'disapprove', $comment_id));
                break;

            case '0':
                return $this->Html->link(__('Approve'), array('action' => 'approve', $comment_id));
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

}

?>
