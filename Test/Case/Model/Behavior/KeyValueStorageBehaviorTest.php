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
