<?php
/**
 * User Meta test
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
        $this->UserMeta = ClassRegistry::init('UserMeta');
    }

    public function testGetInstance()
    {
        $firstName = $this->UserMeta->field(
            'meta_value',
            array('UserMeta.user_id' => 1, 'UserMeta.meta_key' => 'first_name')
        );
        $this->assertEquals($firstName, 'Mohammad', 'First name');
    }
}
