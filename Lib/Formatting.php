<?php

App::import('Vendor', 'kses');
App::import('Lib', 'Functions');

/**
 * Description of Formatting
 *
 * @author mohammad
 */
class Formatting {

    /**
     * Escaping for HTML blocks.
     *
     * @since 1.0
     *
     * @param string $text
     * @return string
     */
    function esc_html($text) {
        $safe_text = $this->hr_check_invalid_utf8($text);
        $safe_text = $this->_hr_specialchars($safe_text, ENT_QUOTES);
        //return apply_filters('esc_html', $safe_text, $text);
        return $safe_text;
    }

    /**
     * Escaping for HTML attributes.
     *
     * @since 1.0
     *
     * @param string $text
     * @return string
     */
    function esc_attr($text) {
        $safe_text = Formatting::hr_check_invalid_utf8($text);
        $safe_text = Formatting::_hr_specialchars($safe_text, ENT_QUOTES);
        return $safe_text;
    }

    /**
     * Checks and cleans a URL.
     *
     * A number of characters are removed from the URL. If the URL is for displaying
     * (the default behaviour) ampersands are also replaced. The 'clean_url' filter
     * is applied to the returned cleaned URL.
     *
     * @since 1.0
     * @uses kses_bad_protocol() To only permit protocols in the URL set
     *              via $protocols or the common ones set in the function.
     *
     * @param string $url The URL to be cleaned.
     * @param array $protocols Optional. An array of acceptable protocols.
     *              Defaults to 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn' if not set.
     * @param string $_context Private. Use esc_url_raw() for database usage.
     * @return string The cleaned $url after the 'clean_url' filter is applied.
     */
    function esc_url($url, $protocols = null, $_context = 'display') {

        if ('' == $url)
            return $url;
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = Formatting::_deep_replace($strip, $url);
        $url = str_replace(';//', '://', $url);
        /* If the URL doesn't appear to contain a scheme, we
         * presume it needs http:// appended (unless a relative
         * link starting with /, # or ? or a php file).
         */
        if (strpos($url, ':') === false && !in_array($url[0], array('/', '#', '?')) &&
                !preg_match('/^[a-z0-9-]+?\.php/i', $url))
            $url = 'http://' . $url;

        // Replace ampersands and single quotes only when displaying.
        if ('display' == $_context) {
            $url = kses_normalize_entities($url);
            $url = str_replace('&amp;', '&#038;', $url);
            $url = str_replace("'", '&#039;', $url);
        }

        if (!is_array($protocols))
            $protocols = allowed_protocols();
        if (kses_bad_protocol($url, $protocols) != $url)
            return '';

        //return apply_filters('clean_url', $url, $original_url, $_context);
        return $url;
    }

    /**
     * Checks for invalid UTF8 in a string.
     *
     * @since 1.0
     *
     * @param string $string The text which is to be checked.
     * @param boolean $strip Optional. Whether to attempt to strip out invalid UTF8. Default is false.
     * @return string The checked text.
     */
    function hr_check_invalid_utf8($string, $strip = false) {
        $string = (string) $string;

        if (0 === strlen($string)) {
            return '';
        }

        // Store the site charset as a static to avoid multiple calls to get_option()
        static $is_utf8;
        if (!isset($is_utf8)) {
            $is_utf8 = in_array(Configure::read('site_charset'), array('utf8', 'utf-8', 'UTF8', 'UTF-8'));
        }
        if (!$is_utf8) {
            return $string;
        }

        // Check for support for utf8 in the installed PCRE library once and store the result in a static
        static $utf8_pcre;
        if (!isset($utf8_pcre)) {
            $utf8_pcre = @preg_match('/^./u', 'a');
        }
        // We can't demand utf8 in the PCRE installation, so just return the string in those cases
        if (!$utf8_pcre) {
            return $string;
        }

        // preg_match fails when it encounters invalid UTF8 in $string
        if (1 === @preg_match('/^./us', $string)) {
            return $string;
        }

        // Attempt to strip the bad chars if requested (not recommended)
        if ($strip && function_exists('iconv')) {
            return iconv('utf-8', 'utf-8', $string);
        }

        return '';
    }

    /**
     * Converts a number of special characters into their HTML entities.
     *
     * Specifically deals with: &, <, >, ", and '.
     *
     * $quote_style can be set to ENT_COMPAT to encode " to
     * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
     *
     * @since 1.0
     *
     * @param string $string The text which is to be encoded.
     * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @param string $charset Optional. The character encoding of the string. Default is false.
     * @param boolean $double_encode Optional. Whether to encode existing html entities. Default is false.
     * @return string The encoded text with HTML entities.
     */
    function _hr_specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false) {
        $string = (string) $string;

        if (0 === strlen($string))
            return '';

        // Don't bother if there are no specialchars - saves some processing
        if (!preg_match('/[&<>"\']/', $string))
            return $string;

        // Account for the previous behaviour of the function when the $quote_style is not an accepted value
        if (empty($quote_style))
            $quote_style = ENT_NOQUOTES;
        elseif (!in_array($quote_style, array(0, 2, 3, 'single', 'double'), true))
            $quote_style = ENT_QUOTES;

        // Store the site charset as a static to avoid multiple calls to wp_load_alloptions()
        if (!$charset) {
            static $_charset;
            if (!isset($_charset)) {
                $alloptions = wp_load_alloptions();
                $_charset = isset($alloptions['blog_charset']) ? $alloptions['blog_charset'] : '';
            }
            $charset = $_charset;
        }

        if (in_array($charset, array('utf8', 'utf-8', 'UTF8')))
            $charset = 'UTF-8';

        $_quote_style = $quote_style;

        if ($quote_style === 'double') {
            $quote_style = ENT_COMPAT;
            $_quote_style = ENT_COMPAT;
        } elseif ($quote_style === 'single') {
            $quote_style = ENT_NOQUOTES;
        }

        // Handle double encoding ourselves
        if ($double_encode) {
            $string = @htmlspecialchars($string, $quote_style, $charset);
        } else {
            // Decode &amp; into &
            $string = $this->hr_specialchars_decode($string, $_quote_style);

            // Guarantee every &entity; is valid or re-encode the &
            $string = $kses->normalizeEntities($string);

            // Now re-encode everything except &entity;
            $string = preg_split('/(&#?x?[0-9a-z]+;)/i', $string, -1, PREG_SPLIT_DELIM_CAPTURE);

            for ($i = 0; $i < count($string); $i += 2)
                $string[$i] = @htmlspecialchars($string[$i], $quote_style, $charset);

            $string = implode('', $string);
        }

        // Backwards compatibility
        if ('single' === $_quote_style)
            $string = str_replace("'", '&#039;', $string);

        return $string;
    }

    /**
     * Converts a number of HTML entities into their special characters.
     *
     * Specifically deals with: &, <, >, ", and '.
     *
     * $quote_style can be set to ENT_COMPAT to decode " entities,
     * or ENT_QUOTES to do both " and '. Default is ENT_NOQUOTES where no quotes are decoded.
     *
     * @since 2.8
     *
     * @param string $string The text which is to be decoded.
     * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old _wp_specialchars() values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @return string The decoded text without HTML entities.
     */
    function hr_specialchars_decode($string, $quote_style = ENT_NOQUOTES) {
        $string = (string) $string;

        if (0 === strlen($string)) {
            return '';
        }

        // Don't bother if there are no entities - saves a lot of processing
        if (strpos($string, '&') === false) {
            return $string;
        }

        // Match the previous behaviour of _hr_specialchars() when the $quote_style is not an accepted value
        if (empty($quote_style)) {
            $quote_style = ENT_NOQUOTES;
        } elseif (!in_array($quote_style, array(0, 2, 3, 'single', 'double'), true)) {
            $quote_style = ENT_QUOTES;
        }

        // More complete than get_html_translation_table( HTML_SPECIALCHARS )
        $single = array('&#039;' => '\'', '&#x27;' => '\'');
        $single_preg = array('/&#0*39;/' => '&#039;', '/&#x0*27;/i' => '&#x27;');
        $double = array('&quot;' => '"', '&#034;' => '"', '&#x22;' => '"');
        $double_preg = array('/&#0*34;/' => '&#034;', '/&#x0*22;/i' => '&#x22;');
        $others = array('&lt;' => '<', '&#060;' => '<', '&gt;' => '>', '&#062;' => '>', '&amp;' => '&', '&#038;' => '&', '&#x26;' => '&');
        $others_preg = array('/&#0*60;/' => '&#060;', '/&#0*62;/' => '&#062;', '/&#0*38;/' => '&#038;', '/&#x0*26;/i' => '&#x26;');

        if ($quote_style === ENT_QUOTES) {
            $translation = array_merge($single, $double, $others);
            $translation_preg = array_merge($single_preg, $double_preg, $others_preg);
        } elseif ($quote_style === ENT_COMPAT || $quote_style === 'double') {
            $translation = array_merge($double, $others);
            $translation_preg = array_merge($double_preg, $others_preg);
        } elseif ($quote_style === 'single') {
            $translation = array_merge($single, $others);
            $translation_preg = array_merge($single_preg, $others_preg);
        } elseif ($quote_style === ENT_NOQUOTES) {
            $translation = $others;
            $translation_preg = $others_preg;
        }

        // Remove zero padding on numeric entities
        $string = preg_replace(array_keys($translation_preg), array_values($translation_preg), $string);

        // Replace characters according to translation table
        return strtr($string, $translation);
    }

    /**
     * Perform a deep string replace operation to ensure the values in $search are no longer present
     *
     * Repeats the replacement operation until it no longer replaces anything so as to remove "nested" values
     * e.g. $subject = '%0%0%0DDD', $search ='%0D', $result ='' rather than the '%0%0DD' that
     * str_replace would return
     *
     * @since 2.8.1
     * @access private
     *
     * @param string|array $search
     * @param string $subject
     * @return string The processed string
     */
    function _deep_replace($search, $subject) {
        $found = true;
        $subject = (string) $subject;
        while ($found) {
            $found = false;
            foreach ((array) $search as $val) {
                while (strpos($subject, $val) !== false) {
                    $found = true;
                    $subject = str_replace($val, '', $subject);
                }
            }
        }

        return $subject;
    }

    /**
     * Santizes a html classname to ensure it only contains valid characters
     *
     * Strips the string down to A-Z,a-z,0-9,_,-. If this results in an empty
     * string then it will return the alternative value supplied.
     *
     * @todo Expand to support the full range of CDATA that a class attribute can contain.
     *
     * @since 0.1
     *
     * @param string $class The classname to be sanitized
     * @param string $fallback Optional. The value to return if the sanitization end's up as an empty string.
     *      Defaults to an empty string.
     * @return string The sanitized value
     */
    function sanitize_html_class($class, $fallback = '') {
        //Strip out any % encoded octets
        $sanitized = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|', '', $class);

        //Limit to A-Z,a-z,0-9,_,-
        $sanitized = preg_replace('/[^A-Za-z0-9_-]/', '', $sanitized);

        if ('' == $sanitized)
            $sanitized = $fallback;

        return $sanitized;
    }

}

?>
