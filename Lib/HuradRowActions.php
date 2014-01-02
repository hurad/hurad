<?php
/**
 * Row actions library
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
 * Class HuradRowActions
 *
 * @todo Complete phpDoc
 */
class HuradRowActions
{

    protected static $rows = array();
    protected static $actions = array();

    public static function addAction($action, $link, $capability, $options = array())
    {
        self::$actions[$action] = array('link' => $link, 'capability' => $capability, 'options' => $options);
    }

    public static function getActions()
    {
        return self::$actions;
    }

}