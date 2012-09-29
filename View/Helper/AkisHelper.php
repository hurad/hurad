<?php
App::uses('AppHelper', 'View/Helper');

class AkisHelper extends AppHelper {

    public $helpers = array('Html');
    public $components = array('Akismet');

    function isValid() {
        if ($this->Akismet->isKeyValid()) {
            echo 'OK';
        } else {
            echo 'Error';
        }
    }

}

?>