<?php
/**
 * User controller test
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
App::uses('UsersController', 'Controller');

/**
 * Class UsersControllerTest
 */
class UsersControllerTest extends ControllerTestCase
{
    public $fixtures = ['app.user', 'app.userMeta', 'app.comment', 'app.category', 'app.tag', 'app.post', 'app.media'];
    public $User;

    public function testAdminIndex()
    {
        $this->testAction('/admin/users/index');
        $this->assertInternalType('array', $this->vars['users']);
    }
}
