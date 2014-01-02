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

}