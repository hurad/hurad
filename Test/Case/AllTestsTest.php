<?php
/**
 * Load all tests
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
 * AllTests class
 *
 * This test group will run all tests.
 *
 * @package       Cake.Test.Case
 */
class AllTests extends PHPUnit_Framework_TestSuite
{
    /**
     * Suite define the tests for this suite
     *
     * @return void
     */
    public static function suite()
    {
        $suite = new CakeTestSuite('All Tests');
        $suite->addTestDirectoryRecursive(APP . 'Test/Case');
        return $suite;
    }
}
