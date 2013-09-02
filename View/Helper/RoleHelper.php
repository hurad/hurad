<?php

/**
 * Description of HuradHelper
 *
 * @author mohammad
 */
class RoleHelper extends AppHelper
{

    public function currentUserCan($cap)
    {
        if (isset($this->_View->viewVars['current_user'])) {
            $role = $this->_View->viewVars['current_user']['role'];
            return in_array($cap, HuradRole::$roles[$role]['capabilities']);
        }

        return false;
    }

}