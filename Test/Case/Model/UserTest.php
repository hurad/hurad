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

}

?>
