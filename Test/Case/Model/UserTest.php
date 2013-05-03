<?php

App::import('Model', 'User');

/**
 * Description of UserTest
 *
 * @author mohammad
 */
class UserTest extends CakeTestCase {

    public $fixtures = array('user');
    public $User;

    public function setUp() {

        $this->User = & ClassRegistry::init('User');
    }

    public function testGetInstance() {

        $created = $this->User->field('created', array('User.username' => 'atkrad'));

        $this->assertEquals($created, '2007-03-17 01:16:23', 'Created Date');
    }

    public function testGetUserData() {
        $result = $this->User->getUserData(1);

        $expected = array(
            array('User' => array('id' => 1, 'username' => 'Ali')),
//            array('Article' => array('id' => 2, 'title' => 'Second Article')),
//            array('Article' => array('id' => 3, 'title' => 'Third Article'))
        );

        $this->assertEquals($expected, $result);
    }

}