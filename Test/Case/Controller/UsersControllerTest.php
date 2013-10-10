<?php

App::uses('UsersController', 'Controller');

/**
 * Class UsersControllerTest
 */
class UsersControllerTest extends ControllerTestCase
{

    public $fixtures = array('app.user', 'app.userMeta', 'app.comment', 'app.category', 'app.tag', 'app.post');
    public $User;

    public function testAdminIndex()
    {
        $this->testAction('/admin/users/index');
        $this->assertInternalType('array', $this->vars['users']);
    }

}