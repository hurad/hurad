<?php
/**
 * Media fixture
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
 * Class MediaFixture
 */
class MediaFixture extends CakeTestFixture
{

    /**
     * Name of the object
     *
     * @var string
     */
    public $name = 'Media';

    /**
     * Full Table Name
     *
     * @var string
     */
    public $table = 'media';

    /**
     * Fields / Schema for the fixture.
     * This array should match the output of Model::schema()
     *
     * @var array
     */
    public $fields = [
        'id' => ['type' => 'integer', 'key' => 'primary'],
        'user_id' => ['type' => 'integer', 'null' => false],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false],
        'description' => ['type' => 'text', 'null' => false],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false],
        'original_name' => ['type' => 'string', 'length' => 255, 'null' => false],
        'mime_type' => ['type' => 'string', 'length' => 255, 'null' => false],
        'size' => ['type' => 'integer', 'null' => false],
        'extension' => ['type' => 'string', 'length' => 5, 'null' => false],
        'path' => ['type' => 'string', 'length' => 12, 'null' => false],
        'web_path' => ['type' => 'text', 'null' => false],
        'created' => 'datetime',
        'modified' => 'datetime'
    ];
}
