<?php
/**
 * User test
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('User', 'Model');

/**
 * Class UserTest
 */
class UserTest extends CakeTestCase
{
    public $fixtures = array('app.user', 'app.userMeta');
    public $User;

    /**
     * Setup the test case, backup the static object values so they can be restored.
     * Specifically backs up the contents of Configure and paths in App if they have
     * not already been backed up.
     *
     * @return void
     */
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
                'first_name' => 'Mohammad',
                'last_name' => 'Abdoli Rad',
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
