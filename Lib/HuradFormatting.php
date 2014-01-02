<?php
/**
 * Formatting library
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
 * Class HuradFormatting
 *
 * @todo Complete phpDoc
 */
class HuradFormatting
{

    public static function clickAbleLink($url, $chrLimit = 35, $add = '...')
    {
        return preg_replace(
            "!(http:/{2}[\w\.]{2,}[/\w\-\.\?\&\=\#]*)!e",
            "'<a href=\"\\1\" title=\"\\1\" target=\"_blank\">'.(strlen('\\1')>=$chrLimit ? substr('\\1',0,$chrLimit).'$add':'\\1').'</a>'",
            $url
        );
    }

    public static function convertEmoticons($text)
    {
        /**
         * @todo complete this method
         * use this emoticons:
         * http://messenger.yahoo.com/features/emoticons/
         * http://messenger.yahoo.com/features/hiddenemoticons/
         */
        return $text;
    }

}