<?php

class HelloController extends HelloWorldAppController
{

    var $name = 'Hello';

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function admin_index()
    {
        $this->set('title_for_layout', __('Hello World'));
    }

}

?>
