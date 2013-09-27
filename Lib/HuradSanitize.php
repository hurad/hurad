<?php

class HuradSanitize
{
    /**
     * Sanitize URL
     *
     * @param string $url Url address
     *
     * @return mixed
     */
    public static function url($url)
    {
        $sanitizeUrl = filter_var($url, FILTER_SANITIZE_URL);
        return HuradHook::apply_filters('sanitize_url', $sanitizeUrl);
    }

    public static function textarea($text)
    {
        $safeText = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return HuradHook::apply_filters('sanitize_textarea', $safeText, $text);
    }

    public static function title($title, $with = 'default', $when = 'save')
    {
        switch ($with) {
            case'dash':

                $title = strip_tags($title);
                if (HuradFunctions::isUtf8($title)) {
                    if (function_exists('mb_strtolower')) {
                        $title = mb_strtolower($title, 'utf8');
                    }
                    $title = HuradFunctions::utf8UriEncode($title, 200);
                }
                $title = strtolower($title);
                //Kill entity
                $title = preg_replace('/&.+?;/', ' ', $title);
                $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
                //Replace whitespace with dash
                $title = preg_replace('/\s+/', '-', $title);
                //Replace multi dash with one dash
                $title = preg_replace('/-+/', '-', $title);
                //Remove dash from start and end of string
                $title = trim($title, '-');
                return HuradHook::apply_filters('sanitize_title_with_dash', $title);
                break;
            case'default':
            default:
                if ($when == "save") {
                    $safeTitle = filter_var($title, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                } else {
                    $safeTitle = $title;
                }
                return HuradHook::apply_filters('sanitize_title', $safeTitle, $title, $when);
                break;
        }
    }

    public static function htmlClass($class)
    {
        if (is_array($class)) {
            $class = implode(' ', $class);
        }

        $rawClass = $class;

        $class = filter_var($class, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $class = preg_replace('/[^A-Za-z0-9_-]/', '', $class);
        return HuradHook::apply_filters('sanitize_html_class', $class, $rawClass);
    }

    public static function htmlAttribute($attribute)
    {
        $rawAttribute = $attribute;
        $attribute = filter_var($attribute, FILTER_SANITIZE_SPECIAL_CHARS);
        return HuradHook::apply_filters('sanitize_html_attribute', $attribute, $rawAttribute);
    }

}