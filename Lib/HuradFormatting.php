<?php
/**
 * Class HuradFormatting
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