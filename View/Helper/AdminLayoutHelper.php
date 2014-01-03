<?php
/**
 * Admin Layout helper
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
 * Class AdminLayoutHelper
 */
class AdminLayoutHelper extends AppHelper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html', 'Js', 'Form', 'Role', 'Content'];

    public function postStatus($value)
    {
        if ($value == 'publish') {
            $output = $this->Html->tag('span', __d('hurad', 'Publish'), array('class' => 'label label-success'));
        } elseif ($value == 'draft') {
            $output = $this->Html->tag('span', __d('hurad', 'Draft'), array('class' => 'label label-warning'));
        } elseif ($value == 'trash') {
            $output = $this->Html->tag('span', __d('hurad', 'Trash'), array('class' => 'label label-important'));
        } else {
            $output = __d('hurad', 'Unknown');
        }
        return $output;
    }

    public function linkVisible($value)
    {
        if ($value == 'Y') {
            $output = __d('hurad', 'Yes');
        } elseif ($value == 'N') {
            $output = __d('hurad', 'No');
        } else {
            $output = __d('hurad', 'Unknown');
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
            $output .= __d('hurad', 'This key is valid.');
            $output .= '</p>';
        } elseif ($valid === false) {
            $output = '<p class="akismet_error">';
            $output .= __d('hurad', 'This key is not valid.');
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
                return __d('hurad', 'Administrator');
                break;
            case "editor":
                return __d('hurad', 'Editor');
                break;
            case "author":
                return __d('hurad', 'Author');
                break;
            case "user":
                return __d('hurad', 'User');
                break;
        }
    }

    public function toggleCommentLink($status, $commentId)
    {
        switch ($status) {
            case 'approved':
                return $this->Html->link(
                    __d('hurad', 'Disapprove'),
                    array('action' => 'action', 'disapproved', $commentId)
                );
                break;

            case 'disapproved':
                return $this->Html->link(__d('hurad', 'Approve'), array('action' => 'action', 'approved', $commentId));
                break;

            case 'spam':
                return $this->Html->link(__d('hurad', 'Un Spam'), array('action' => 'action', 'approved', $commentId));
                break;

            case 'trash':
                return $this->Form->postLink(
                    __d('hurad', 'Delete'),
                    array('admin' => true, 'controller' => 'comments', 'action' => 'delete', $commentId),
                    null,
                    __d('hurad', 'Are you sure you want to delete “#%s”?', $commentId)
                );
                break;

            default:
                break;
        }
    }

    /**
     * Get current user data
     *
     * @param string $field Field name
     *
     * @return bool|string
     */
    public function currentUser($field = 'username')
    {
        $currentUser = $this->_View->get('current_user');

        if (!$currentUser) {
            return false;
        }

        if (array_key_exists($field, $currentUser['User'])) {
            return $currentUser['User'][(string)$field];
        } elseif (array_key_exists($field, $currentUser['UserMeta'])) {
            return $currentUser['UserMeta'][(string)$field];
        } else {
            return false;
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
        echo $this->Html->tag('div', null, array('id' => 'accordion', 'class' => 'panel-group'));
        foreach ($options as $value => $val) {
            if ($this->Role->currentUserCan($val['capability'])) {
                echo $this->Html->tag('div', null, array('class' => 'panel panel-default'));
                echo $this->Html->tag('div', null, array('class' => 'panel-heading'));
                echo $this->Html->tag('h4', null, array('class' => 'panel-title'));
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
                echo ' ' . $val['title'];
                echo '</a>'; //a.accordion-toggle
                echo '</h4>'; //h4.panel-title
                echo '</div>'; //div.panel-heading

                if (isset($val['sub_menus']) && is_array($val['sub_menus'])) {
                    echo $this->Html->tag(
                        'div',
                        null,
                        array(
                            'id' => 'collapse-' . $value,
                            'class' => 'panel-collapse collapse',
                            'style' => 'height: auto;'
                        )
                    );
                    echo $this->Html->tag('div', null, array('class' => 'panel-body'));

                    echo $this->Html->tag('ul', null, array('class' => 'list-group'));
                    foreach ($val['sub_menus'] as $key => $value) {
                        if ($this->Role->currentUserCan($value['capability'])) {
                            echo $this->Html->link($value['title'], $value['url'], array('class' => 'list-group-item'));
                        }
                    }
                    echo '</ul>'; //ul.nav .nav-list
                    echo '</div>'; //div.panel-body
                    echo '</div>'; //div.panel-collapse .collapse .in
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
        $user = ClassRegistry::init('User')->getUser($userID);
        $options = array();
        $options[$user['User']['username']] = $user['User']['username'];

        if (!empty($user['UserMeta']['first_name']) && !empty($user['UserMeta']['last_name'])) {
            $options[$user['UserMeta']['first_name'] . ' ' . $user['UserMeta']['last_name']] = $user['UserMeta']['first_name'] . ' ' . $user['UserMeta']['last_name'];
            $options[$user['UserMeta']['last_name'] . ' ' . $user['UserMeta']['first_name']] = $user['UserMeta']['last_name'] . ' ' . $user['UserMeta']['first_name'];
        }

        if (!empty($user['UserMeta']['first_name']) && empty($user['UserMeta']['last_name'])) {
            $options[$user['UserMeta']['first_name']] = $user['UserMeta']['first_name'];
        }

        if (empty($user['UserMeta']['first_name']) && !empty($user['UserMeta']['last_name'])) {
            $options[$user['UserMeta']['last_name']] = $user['UserMeta']['last_name'];
        }

        if (!empty($user['UserMeta']['nickname'])) {
            $options[$user['UserMeta']['nickname']] = $user['UserMeta']['nickname'];
        }

        return $options;
    }

    public function commentClass($status = null)
    {
        switch ($status) {
            case 'disapproved':
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

        return implode(" | ", $links);
    }
}
