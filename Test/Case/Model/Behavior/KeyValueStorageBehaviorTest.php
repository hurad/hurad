<?php

/**
 * Class KeyValueStorageBehaviorTest
 *
 * @property UserMeta $UserMeta
 */
class KeyValueStorageBehaviorTest extends CakeTestCase
{
    public $fixtures = ['app.userMeta'];


    public function setUp()
    {
        parent::setUp();
        $this->UserMeta = ClassRegistry::init('UserMeta');
    }

    public function testSaveData()
    {
        $data = [
            'UserMeta' => [
                'firstname' => 'Ali',
                'lastname' => 'Rad',
                'nickname' => 'hulk',
                'display_name' => 'Dr Ali'
            ]
        ];

        $this->UserMeta->user_id = 3;
        $this->UserMeta->saveData($data);
        $this->assertEqual($this->UserMeta->getData(), $data['UserMeta']);

        $dataTwo = [
            'UserMeta' => [
                'firstname' => 'Hasan',
                'lastname' => 'Rad',
                'nickname' => 'dr-hulk',
                'display_name' => 'admin'
            ]
        ];
        $this->UserMeta->user_id = 3;
        $this->UserMeta->saveData($dataTwo);
        $this->assertNotEqual($this->UserMeta->getData(), $data['UserMeta']);
        $this->assertEqual($this->UserMeta->getData(), $dataTwo['UserMeta']);
    }

    public function testGetData()
    {
        $data = $this->UserMeta->getData();
        $this->assertEqual($data, []);

        $this->UserMeta->user_id = 1;
        $data = $this->UserMeta->getData();

        $expected = [
            'firstname' => 'Mohammad',
            'lastname' => 'Abdoli Rad',
            'nickname' => 'atkrad',
            'bio' => '',
            'display_name' => 'Mohammad'
        ];

        $this->assertEqual($data, $expected);
    }
}
