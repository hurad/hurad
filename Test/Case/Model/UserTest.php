<?php

App::uses('User', 'Model');

/**
 * Class UserTest
 */
class UserTest extends CakeTestCase
{

    public $fixtures = array('app.user', 'app.userMeta');
    public $User;

    public function setUp()
    {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    public function testGetInstance()
    {
        $created = $this->User->field('created', array('User.username' => 'admin'));

        $this->assertEquals($created, '2013-03-17 01:16:23', 'Created Date');
    }

    public function testGetUsers()
    {
        $args = array(
            'order_by' => 'created',
            'order' => 'asc',
            'limit' => 2
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
                    'created' => '2013-03-17 01:16:23',
                    'modified' => '2013-03-17 01:16:23',
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
                    'created' => '2013-03-18 01:18:23',
                    'modified' => '2013-03-18 01:18:23',
                )
            )
        );

        $this->assertEquals($expected, $result);
    }

    public function testGetUser()
    {
        $result = $this->User->getUser(1);

        $expected = [
            'User' => [
                'id' => '1',
                'username' => 'admin',
                'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
                'email' => 'admin@example.org',
                'url' => '',
                'role' => 'admin',
                'activation_key' => '',
                'reset_key' => '',
                'status' => '0',
                'created' => '2013-03-17 01:16:23',
                'modified' => '2013-03-17 01:16:23'
            ],
            'UserMeta' => [
                'firstname' => 'Mohammad',
                'lastname' => 'Abdoli Rad',
                'nickname' => 'atkrad',
                'bio' => '',
                'display_name' => 'Mohammad'
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testDeleteUsers()
    {
        //Delete first admin
        $this->User->id = 1;
        $result = $this->User->delete();
        $this->assertFalse($result);

        //Delete other user
        $this->User->id = 4;
        $result = $this->User->delete();
        $this->assertTrue($result);

        //Delete user with UserMeta records
        $this->User->id = 2;
        $this->User->delete();
        $result = $this->User->getUser(2);
        $this->assertFalse($result);
    }

}