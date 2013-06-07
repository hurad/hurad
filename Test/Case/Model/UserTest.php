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

    public function testGetUsers() {
        $args = array(
            'orderby' => 'created',
            'order' => 'asc',
            'number' => 2
        );

        $result = $this->User->getUsers($args);

        $expected = array(
            0 => array(
                'User' => array(
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
                )
            ),
            1 => array(
                'User' => array(
                    'id' => '2',
                    'username' => 'editor',
                    'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
                    'email' => 'editor@example.org',
                    'url' => '',
                    'role' => 'editor',
                    'activation_key' => '',
                    'reset_key' => '',
                    'status' => '0',
                    'created' => '2007-03-17 01:18:23',
                    'modified' => '2007-03-17 01:20:31',
                )
            )
        );

        $this->assertEquals($expected, $result);
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

    public function testDeleteUsers() {
        $this->User->id = 1;
        $this->User->delete();
        $result = $this->User->getUserData(1);
        $this->assertFalse($result);
    }

}