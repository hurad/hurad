<?php

/**
 * Description of HuradRole
 *
 * @author mohammad
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