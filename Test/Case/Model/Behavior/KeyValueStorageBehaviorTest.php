<?php
/**
 * Key Value Storage behavior test
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

/**
 * Class KeyValueStorageBehaviorTest
 *
 * @property UserMeta $UserMeta
 */
class KeyValueStorageBehaviorTest extends CakeTestCase
{
    public $fixtures = ['app.userMeta'];

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

    /**
     * Save data test
     */
    public function testSaveData()
    {
        $data = [
            'UserMeta' => [
                'first_name' => 'Ali',
                'last_name' => 'Rad',
                'nickname' => 'hulk',
                'display_name' => 'Dr Ali'
            ]
        ];

        $this->UserMeta->user_id = 3;
        $this->UserMeta->saveData($data);
        $this->assertEqual($this->UserMeta->getData(), $data);

        $dataTwo = [
            'UserMeta' => [
                'first_name' => 'Hasan',
                'last_name' => 'Rad',
                'nickname' => 'dr-hulk',
                'display_name' => 'admin'
            ]
        ];
        $this->UserMeta->user_id = 3;
        $this->UserMeta->saveData($dataTwo);
        $this->assertNotEqual($this->UserMeta->getData(), $data);
        $this->assertEqual($this->UserMeta->getData(), $dataTwo);
    }

    /**
     * Get data test
     */
    public function testGetData()
    {
        $data = $this->UserMeta->getData();
        $this->assertEqual($data, []);

        $this->UserMeta->user_id = 1;
        $data = $this->UserMeta->getData();

        $expected = [
            'UserMeta' => [
                'first_name' => 'Mohammad',
                'last_name' => 'Abdoli Rad',
                'nickname' => 'atkrad',
                'bio' => '',
                'display_name' => 'Mohammad'
            ]
        ];

        $this->assertEqual($data, $expected);
    }
}
