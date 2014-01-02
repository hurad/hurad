<?php
/**
 * Functions library
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
 * Class HuradFunctions
 *
 * @todo Complete phpDoc
 */
class HuradFunctions
{
    /**
     * @param $string
     *
     * @return bool|string
     */
    public static function isUtf8($string)
    {
        if (function_exists('mb_detect_encoding')) {
            return mb_detect_encoding($string, 'utf-8');
        } else {
            $c = 0;
            $b = 0;
            $bits = 0;
            $len = strlen($string);
            for ($i = 0; $i < $len; $i++) {
                $c = ord($string[$i]);
                if ($c > 128) {
                    if (($c >= 254)) {
                        return false;
                    } elseif ($c >= 252) {
                        $bits = 6;
                    } elseif ($c >= 248) {
                        $bits = 5;
                    } elseif ($c >= 240) {
                        $bits = 4;
                    } elseif ($c >= 224) {
                        $bits = 3;
                    } elseif ($c >= 192) {
                        $bits = 2;
                    } else {
                        return false;
                    }
                    if (($i + $bits) > $len) {
                        return false;
                    }
                    while ($bits > 1) {
                        $i++;
                        $b = ord($string[$i]);
                        if ($b < 128 || $b > 191) {
                            return false;
                        }
                        $bits--;
                    }
                }
            }
            return true;
        }
    }

    /**
     * Encode the Unicode values to be used in the URI.
     *
     * @param string $utf8String Max length of the string
     * @param int    $length
     *
     * @return string String with Unicode encoded for URI.
     */
    public static function utf8UriEncode($utf8String, $length = 0)
    {
        $unicode = '';
        $values = array();
        $numOctets = 1;
        $unicodeLength = 0;

        $string_length = strlen($utf8String);
        for ($i = 0; $i < $string_length; $i++) {

            $value = ord($utf8String[$i]);

            if ($value < 128) {
                if ($length && ($unicodeLength >= $length)) {
                    break;
                }
                $unicode .= chr($value);
                $unicodeLength++;
            } else {
                if (count($values) == 0) {
                    $numOctets = ($value < 224) ? 2 : 3;
                }

                $values[] = $value;

                if ($length && ($unicodeLength + ($numOctets * 3)) > $length) {
                    break;
                }
                if (count($values) == $numOctets) {
                    if ($numOctets == 3) {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                        $unicodeLength += 9;
                    } else {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                        $unicodeLength += 6;
                    }

                    $values = array();
                    $numOctets = 1;
                }
            }
        }

        return $unicode;
    }

    /**
     * Extract a slice of an array, given a list of keys.
     *
     * @param array $array The original array
     * @param array $keys  The list of keys
     *
     * @return array The array slice
     */
    public static function arraySliceAssoc($array, $keys)
    {
        $slice = array();
        foreach ($keys as $key) {
            if (isset($array[$key])) {
                $slice[$key] = $array[$key];
            }
        }

        return $slice;
    }

    /**
     * Convert integer number to format based on the locale.
     *
     * @param int $number   The number to convert based on locale.
     * @param int $decimals Precision of the number of decimal places.
     *
     * @return string Converted number in string format.
     */
    public static function numberFormatI18n($number, $decimals = 0)
    {
        $rawNumber = $number;
        $formatted = number_format(
            $number,
            self::absInt($decimals),
            Configure::read('decimal_point'),
            Configure::read('thousands_sep')
        );

        return HuradHook::apply_filters('Lib.HuradFunctions.numberFormatI18n', $formatted, $rawNumber);
    }

    /**
     * Whether the current request is for a network or blog admin page
     *
     * Does not inform on whether the user is an admin! Use capability checks to
     * tell if the user should be accessing a section or not.
     *
     * @return bool True if inside Hurad administration pages.
     */
    public static function isAdmin()
    {
        /**
         * @todo Use Router class
         */
        $pos = strpos($_SERVER['REQUEST_URI'], 'admin');

        if ($pos === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Converts value to none negative integer.
     *
     * @param mixed $maybeInt Data you wish to have converted to a none negative integer
     *
     * @return int An none negative integer
     */
    public static function absInt($maybeInt)
    {
        return abs(intval($maybeInt));
    }

    /**
     * Converts formatted string to array
     *
     * A string formatted like 'sort=title;' will be converted to
     * array('sort' => 'blog');
     *
     * @param string $string in this format: sort=title;direction=asc;
     *
     * @return array
     */
    public static function stringToArray($string)
    {
        $string = explode(';', $string);
        $stringArr = [];

        foreach ($string as $stringElement) {
            if ($stringElement != null) {
                $stringElementE = explode('=', $stringElement);
                if (isset($stringElementE['1'])) {
                    $stringArr[$stringElementE['0']] = $stringElementE['1'];
                } else {
                    $stringArr[] = $stringElement;
                }
            }
        }

        return $stringArr;
    }

    public static function parseArgs($args, $defaults = array())
    {
        if (is_string($args)) {
            $strArr = self::stringToArray($args);
            return array_merge($defaults, $strArr);
        }

        return null;
    }
}
