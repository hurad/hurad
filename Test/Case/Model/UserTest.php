<?php

App::uses('User', 'Model');

/**
 * Description of UserTest
 *
 * @author mohammad
 */
class UserTest extends CakeTestCase {

    public $fixtures = array('app.user', 'app.userMeta');
    public $User;

    public function setUp() {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    public function testGetInstance() {
        $created = $this->User->field('created', array('User.username' => 'admin'));

        $this->assertEquals($created, '2007-03-17 01:16:23', 'Created Date');
    }

    public function testGetUserData() {
        $result = $this->User->getUserData(1);

        $expected = array(
            'id' => '1',
            'username' => 'admin',
            'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
            'email' => 'admin@example.org',
            'url' => '',
            'role' => 'admin',
            'activation_key' => '',
            'reset_key' => '',
            'status' => '0',
            'created' => '2007-03-17 01:16:23',
            'modified' => '2007-03-17 01:18:31',
            'firstname' => 'Mohammad',
            'lastname' => 'Abdoli Rad',
            'nickname' => 'atkrad',
            'bio' => '',
            'display_name' => 'Mohammad'
        );

        $this->assertEquals($expected, $result);
    }

}