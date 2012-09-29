<?php

/**
 * Description of HuradHelper
 *
 * @author mohammad
 */
class HuradHelper extends AppHelper {
    public function current_user_can($action) {
        switch ($action) {
            case 'edit-post':


                break;

            default:
                break;
        }
        debug($this->_View->viewVars['comments']);
    }
}
