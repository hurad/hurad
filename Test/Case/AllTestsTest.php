<?php

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