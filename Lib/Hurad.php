<?php
/**
 * Hurad library
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
 * Class Hurad
 *
 * @todo Complete phpDoc
 */
class Hurad
{

    public static $behavior = array();

    //@todo Rename to addBehavior
    public static function applyBehavior($modelName, $behaviorName)
    {
        self::$behavior[] = array($modelName => $behaviorName);
    }

    public static function applyProperty($type, $prop)
    {

        switch ($type) {
            case 'behavior':
                foreach (self::$behavior as $array) {
                    if (array_key_exists($prop->name, $array)) {
                        $prop->actsAs = array_merge($prop->actsAs, array($array[$prop->name]));
                    }
                }
                break;

            default:
                break;
        }
    }

    /**
     * Dispatch event
     *
     * @param string $name    Name of the event
     * @param object $subject the object that this event applies to (usually the object that is generating the event)
     * @param mixed  $data    any value you wish to be transported with this event to it can be read by listeners
     */
    public static function dispatchEvent($name, $subject = null, $data = [])
    {
        $event = new CakeEvent($name, $subject, $data);

        if (!$subject) {
            CakeEventManager::instance()->dispatch($event);
        } else {
            $subject->getEventManager()->dispatch($event);
        }
    }

    /**
     * Deny authorization
     *
     * @param null|array|string $methods
     *
     * @return bool
     */
    public static function denyAuth($methods = null)
    {
        if (is_null($methods)) {
            return false;
        }

        $methods = array($methods);

        if (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Allow authorization
     *
     * @param null|array|string $methods
     *
     * @return bool
     */
    public static function allowAuth($methods = null)
    {
        if (is_null($methods)) {
            return true;
        }

        $methods = array($methods);

        if (is_array($methods)) {
            if (in_array(Router::getParam("action"), $methods)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}