<?php
/**
 * Role & Capabilities library
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
 * Class HuradRole
 *
 * @todo Complete phpDoc
 */
class HuradRole
{
    public static $roles = array();
    public static $caps = array();

    public static function addRole($slug, $name, $capabilities = array())
    {
        if (!self::roleExists($slug)) {
            self::$roles[$slug] = array(
                'name' => $name,
                'capabilities' => $capabilities
            );
            Configure::write('Hurad.roles', self::$roles);
        }
    }

    public static function roleExists($roleSlug)
    {
        return Hash::check(self::$roles, $roleSlug);
    }

    public static function getRole($roleSlug)
    {
        if (self::roleExists($roleSlug)) {
            return self::$roles[$roleSlug];
        } else {
            return false;
        }
    }

    public static function removeRole($roleSlug)
    {
        if (self::roleExists($roleSlug)) {
            unset(self::$roles[$roleSlug]);
        } else {
            return false;
        }
    }

    public static function addCap($roleSlug, $cap)
    {
        if (self::roleExists($roleSlug)) {
            if (!self::capExists($roleSlug, $cap)) {
                self::$caps[$roleSlug][] = $cap;
                $result = Hash::insert(self::$roles, $roleSlug . '.capabilities', self::$caps[$roleSlug]);

                self::$roles = $result;
                Configure::write('Hurad.caps', self::$caps);
            }
        }
    }

    public static function capExists($roleSlug, $cap)
    {
        if (count(self::$caps) > 0 && isset(self::$caps[$roleSlug])) {
            return in_array($cap, self::$caps[$roleSlug]);
        } else {
            return false;
        }
    }
}
