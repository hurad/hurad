<?php

App::uses('UsersController', 'Controller');

/**
 * Class UsersControllerTest
 */
class UsersControllerTest extends ControllerTestCase
{

    public $fixtures = ['app.user', 'app.userMeta', 'app.comment', 'app.category', 'app.tag', 'app.post', 'app.media'];
    public $User;

    public function testAdminIndex()
    {
        $this->testAction('/admin/users/index');
        $this->assertInternalType('array', $this->vars['users']);
    }

}