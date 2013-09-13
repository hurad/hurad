<?php

App::uses('UsersController', 'Controller');

/**
 * Description of UsersControllerTest
 *
 * @author mohammad
 */
class UsersControllerTest extends ControllerTestCase
{

    public $fixtures = array('app.user', 'app.userMeta');
    public $User;

    public function setUp()
    {
        parent::setUp();
    }

    public function startTest($method)
    {
        parent::startTest($method);
    }

    public function testAdminIndex()
    {
        $this->testAction('/admin/users/index');
        $this->assertInternalType('array', $this->vars['users']);
        debug($this->vars['users']);
    }

}