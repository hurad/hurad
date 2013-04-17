<?php

class Hurad {

    public static $behavior = array();

    public static function applyBehavior($modelName, $behaviorName) {
        self::$behavior[] = array($modelName => $behaviorName);
    }

    public static function applyProperty($type, $prop) {

        switch ($type) {
            case 'behavior':
                foreach (self::$behavior as $i => $array) {
                    if (key_exists($prop->name, $array)) {
                        $prop->actsAs = array_merge($prop->actsAs, array($array[$prop->name]));
                    }
                }
                break;

            default:
                break;
        }
    }

}