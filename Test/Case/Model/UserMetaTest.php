<?php

App::uses('UserMeta', 'Model');

/**
 * Description of UserTest
 *
 * @author mohammad
 */
class UserMetaTest extends CakeTestCase
{

    public $fixtures = array('app.userMeta', 'app.user');
    public $UserMeta;

    public function setUp()
    {
        parent::setUp();
        $this->UserMeta = ClassRegistry::init('UserMeta');
    }

    public function testGetInstance()
    {
        $firstName = $this->UserMeta->field(
            'meta_value',
            array('UserMeta.user_id' => 1, 'UserMeta.meta_key' => 'firstname')
        );
        $this->assertEquals($firstName, 'Mohammad', 'First name');
    }
}
