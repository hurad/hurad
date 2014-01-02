<?php
/**
 * Role helper
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
 * Class RoleHelper
 */
class RoleHelper extends AppHelper
{
    public function currentUserCan($cap)
    {
        if (isset($this->_View->viewVars['current_user'])) {
            $role = $this->_View->viewVars['current_user']['User']['role'];
            return in_array($cap, HuradRole::$roles[$role]['capabilities']);
        }

        return false;
    }
}
