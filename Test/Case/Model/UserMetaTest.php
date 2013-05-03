<?php

App::import('Model', 'User');

/**
 * Description of UserTest
 *
 * @author mohammad
 */
class UserMetaTest extends CakeTestCase {

    public $fixtures = array('UserMeta');
    public $UserMeta;

    public function setUp() {

        $this->UserMeta = & ClassRegistry::init('UserMeta');
    }


}