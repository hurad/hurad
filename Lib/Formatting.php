<?php

App::import('Vendor', 'kses');

/**
 * Description of Formatting
 *
 * @author mohammad
 */
class Formatting {

    /**
     * Replaces double line-breaks with paragraph elements.
     *
     * A group of regex replaces used to identify text formatted with newlines and
     * replace double line-breaks with HTML paragraph tags. The remaining
     * line-breaks after conversion become <<br />> tags, unless $br is set to '0'
     * or 'false'.
     *
     * @since 1.0.0
     *
     * @param string $pee The text which has to be formatted.
     * @param bool $br Optional. If set, this will convert all remaining line-breaks after paragraphing. Default true.
     * @return string Text which has been converted into correct paragraph tags.
     */
    public function hrautop($pee, $br = true) {
        $pre_tags = array();

        if (trim($pee) === '')
            return '';

        $pee = $pee . "\n"; // just to make things a little easier, pad the end

        if (strpos($pee, '<pre') !== false) {
            $pee_parts = explode('</pre>', $pee);
            $last_pee = array_pop($pee_parts);
            $pee = '';
            $i = 0;

            foreach ($pee_parts as $pee_part) {
                $start = strpos($pee_part, '<pre');

                // Malformed html?
                if ($start === false) {
                    $pee .= $pee_part;
                    continue;
                }

                $name = "<pre hr-pre-tag-$i></pre>";
                $pre_tags[$name] = substr($pee_part, $start) . '</pre>';

                $pee .= substr($pee_part, 0, $start) . $name;
                $i++;
            }

            $pee .= $last_pee;
        }

        $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
        // Space things out a little
        $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|noscript|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';
        $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
        $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
        $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
        if (strpos($pee, '<object') !== false) {
            $pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
            $pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
        }
        $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
        // make paragraphs, including one at the end
        $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
        $pee = '';
        foreach ($pees as $tinkle)
            $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
        $pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
        $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
        $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
        $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
        $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
        $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
        if ($br) {
            $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', 'Formatting::_autop_newline_preservation_helper', $pee);
            $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
            $pee = str_replace('<HRPreserveNewline />', "\n", $pee);
        }
        $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
        $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
        $pee = preg_replace("|\n</p>$|", '</p>', $pee);

        if (!empty($pre_tags))
            $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

        return $pee;
    }

    /**
     * Newline preservation help function for hrautop
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $matches preg_replace_callback matches array
     * @return string
     */
    private function _autop_newline_preservation_helper($matches) {
        return str_replace("\n", "<HRPreserveNewline />", $matches[0]);
    }

    /**
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     * has Bytes Sequences with a maximum length of 4.
     *
     * @since 1.0.0
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    public function seems_utf8($str) {
        $length = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80)
                $n = 0;# 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0)
                $n = 1;# 110bbbbb
            elseif (($c & 0xF0) == 0xE0)
                $n = 2;# 1110bbbb
            elseif (($c & 0xF8) == 0xF0)
                $n = 3;# 11110bbb
            elseif (($c & 0xFC) == 0xF8)
                $n = 4;# 111110bb
            elseif (($c & 0xFE) == 0xFC)
                $n = 5;# 1111110b
            else
                return false;# Does not match any model
            for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    /**
     * Converts a number of special characters into their HTML entities.
     *
     * Specifically deals with: &, <, >, ", and '.
     *
     * $quote_style can be set to ENT_COMPAT to encode " to
     * &quot;, or ENT_QUOTES to do both. Default is ENT_NOQUOTES where no quotes are encoded.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $string The text which is to be encoded.
     * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @param string $charset Optional. The character encoding of the string. Default is false.
     * @param boolean $double_encode Optional. Whether to encode existing html entities. Default is false.
     * @return string The encoded text with HTML entities.
     */
    private function _hr_specialchars($string, $quote_style = ENT_NOQUOTES, $charset = false, $double_encode = false) {
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

        if (!$charset) {
            static $_charset;
            if (!isset($_charset)) {
                if (Configure::read('site_charset')) {
                    $_charset = Configure::read('site_charset');
                } else {
                    $_charset = '';
                }
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
            $string = Formatting::hr_specialchars_decode($string, $_quote_style);

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
     * @since 1.0.0
     *
     * @param string $string The text which is to be decoded.
     * @param mixed $quote_style Optional. Converts double quotes if set to ENT_COMPAT, both single and double if set to ENT_QUOTES or none if set to ENT_NOQUOTES. Also compatible with old _wp_specialchars() values; converting single quotes if set to 'single', double if set to 'double' or both if otherwise set. Default is ENT_NOQUOTES.
     * @return string The decoded text without HTML entities.
     */
    public function hr_specialchars_decode($string, $quote_style = ENT_NOQUOTES) {
        $string = (string) $string;

        if (0 === strlen($string)) {
            return '';
        }

        // Don't bother if there are no entities - saves a lot of processing
        if (strpos($string, '&') === false) {
            return $string;
        }

        // Match the previous behaviour of _wp_specialchars() when the $quote_style is not an accepted value
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
     * Checks for invalid UTF8 in a string.
     *
     * @since 1.0.0
     *
     * @param string $string The text which is to be checked.
     * @param boolean $strip Optional. Whether to attempt to strip out invalid UTF8. Default is false.
     * @return string The checked text.
     */
    public function hr_check_invalid_utf8($string, $strip = false) {
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
     * Encode the Unicode values to be used in the URI.
     *
     * @since 1.0.0
     *
     * @param string $utf8_string
     * @param int $length Max length of the string
     * @return string String with Unicode encoded for URI.
     */
    function utf8_uri_encode($utf8_string, $length = 0) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;

        $string_length = strlen($utf8_string);
        for ($i = 0; $i < $string_length; $i++) {

            $value = ord($utf8_string[$i]);

            if ($value < 128) {
                if ($length && ( $unicode_length >= $length ))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0)
                    $num_octets = ( $value < 224 ) ? 2 : 3;

                $values[] = $value;

                if ($length && ( $unicode_length + ($num_octets * 3) ) > $length)
                    break;
                if (count($values) == $num_octets) {
                    if ($num_octets == 3) {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                        $unicode_length += 9;
                    } else {
                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                        $unicode_length += 6;
                    }

                    $values = array();
                    $num_octets = 1;
                }
            }
        }

        return $unicode;
    }

    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @since 1.0.0
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    public function remove_accents($string) {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        if (Formatting::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                chr(194) . chr(170) => 'a', chr(194) . chr(186) => 'o',
                chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(134) => 'AE', chr(195) . chr(135) => 'C',
                chr(195) . chr(136) => 'E', chr(195) . chr(137) => 'E',
                chr(195) . chr(138) => 'E', chr(195) . chr(139) => 'E',
                chr(195) . chr(140) => 'I', chr(195) . chr(141) => 'I',
                chr(195) . chr(142) => 'I', chr(195) . chr(143) => 'I',
                chr(195) . chr(144) => 'D', chr(195) . chr(145) => 'N',
                chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(158) => 'TH', chr(195) . chr(159) => 's',
                chr(195) . chr(160) => 'a', chr(195) . chr(161) => 'a',
                chr(195) . chr(162) => 'a', chr(195) . chr(163) => 'a',
                chr(195) . chr(164) => 'a', chr(195) . chr(165) => 'a',
                chr(195) . chr(166) => 'ae', chr(195) . chr(167) => 'c',
                chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(176) => 'd', chr(195) . chr(177) => 'n',
                chr(195) . chr(178) => 'o', chr(195) . chr(179) => 'o',
                chr(195) . chr(180) => 'o', chr(195) . chr(181) => 'o',
                chr(195) . chr(182) => 'o', chr(195) . chr(184) => 'o',
                chr(195) . chr(185) => 'u', chr(195) . chr(186) => 'u',
                chr(195) . chr(187) => 'u', chr(195) . chr(188) => 'u',
                chr(195) . chr(189) => 'y', chr(195) . chr(190) => 'th',
                chr(195) . chr(191) => 'y', chr(195) . chr(152) => 'O',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
                // Decompositions for Latin Extended-B
                chr(200) . chr(152) => 'S', chr(200) . chr(153) => 's',
                chr(200) . chr(154) => 'T', chr(200) . chr(155) => 't',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163) => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                chr(198) . chr(160) => 'O', chr(198) . chr(161) => 'o',
                chr(198) . chr(175) => 'U', chr(198) . chr(176) => 'u',
                // grave accent
                chr(225) . chr(186) . chr(166) => 'A', chr(225) . chr(186) . chr(167) => 'a',
                chr(225) . chr(186) . chr(176) => 'A', chr(225) . chr(186) . chr(177) => 'a',
                chr(225) . chr(187) . chr(128) => 'E', chr(225) . chr(187) . chr(129) => 'e',
                chr(225) . chr(187) . chr(146) => 'O', chr(225) . chr(187) . chr(147) => 'o',
                chr(225) . chr(187) . chr(156) => 'O', chr(225) . chr(187) . chr(157) => 'o',
                chr(225) . chr(187) . chr(170) => 'U', chr(225) . chr(187) . chr(171) => 'u',
                chr(225) . chr(187) . chr(178) => 'Y', chr(225) . chr(187) . chr(179) => 'y',
                // hook
                chr(225) . chr(186) . chr(162) => 'A', chr(225) . chr(186) . chr(163) => 'a',
                chr(225) . chr(186) . chr(168) => 'A', chr(225) . chr(186) . chr(169) => 'a',
                chr(225) . chr(186) . chr(178) => 'A', chr(225) . chr(186) . chr(179) => 'a',
                chr(225) . chr(186) . chr(186) => 'E', chr(225) . chr(186) . chr(187) => 'e',
                chr(225) . chr(187) . chr(130) => 'E', chr(225) . chr(187) . chr(131) => 'e',
                chr(225) . chr(187) . chr(136) => 'I', chr(225) . chr(187) . chr(137) => 'i',
                chr(225) . chr(187) . chr(142) => 'O', chr(225) . chr(187) . chr(143) => 'o',
                chr(225) . chr(187) . chr(148) => 'O', chr(225) . chr(187) . chr(149) => 'o',
                chr(225) . chr(187) . chr(158) => 'O', chr(225) . chr(187) . chr(159) => 'o',
                chr(225) . chr(187) . chr(166) => 'U', chr(225) . chr(187) . chr(167) => 'u',
                chr(225) . chr(187) . chr(172) => 'U', chr(225) . chr(187) . chr(173) => 'u',
                chr(225) . chr(187) . chr(182) => 'Y', chr(225) . chr(187) . chr(183) => 'y',
                // tilde
                chr(225) . chr(186) . chr(170) => 'A', chr(225) . chr(186) . chr(171) => 'a',
                chr(225) . chr(186) . chr(180) => 'A', chr(225) . chr(186) . chr(181) => 'a',
                chr(225) . chr(186) . chr(188) => 'E', chr(225) . chr(186) . chr(189) => 'e',
                chr(225) . chr(187) . chr(132) => 'E', chr(225) . chr(187) . chr(133) => 'e',
                chr(225) . chr(187) . chr(150) => 'O', chr(225) . chr(187) . chr(151) => 'o',
                chr(225) . chr(187) . chr(160) => 'O', chr(225) . chr(187) . chr(161) => 'o',
                chr(225) . chr(187) . chr(174) => 'U', chr(225) . chr(187) . chr(175) => 'u',
                chr(225) . chr(187) . chr(184) => 'Y', chr(225) . chr(187) . chr(185) => 'y',
                // acute accent
                chr(225) . chr(186) . chr(164) => 'A', chr(225) . chr(186) . chr(165) => 'a',
                chr(225) . chr(186) . chr(174) => 'A', chr(225) . chr(186) . chr(175) => 'a',
                chr(225) . chr(186) . chr(190) => 'E', chr(225) . chr(186) . chr(191) => 'e',
                chr(225) . chr(187) . chr(144) => 'O', chr(225) . chr(187) . chr(145) => 'o',
                chr(225) . chr(187) . chr(154) => 'O', chr(225) . chr(187) . chr(155) => 'o',
                chr(225) . chr(187) . chr(168) => 'U', chr(225) . chr(187) . chr(169) => 'u',
                // dot below
                chr(225) . chr(186) . chr(160) => 'A', chr(225) . chr(186) . chr(161) => 'a',
                chr(225) . chr(186) . chr(172) => 'A', chr(225) . chr(186) . chr(173) => 'a',
                chr(225) . chr(186) . chr(182) => 'A', chr(225) . chr(186) . chr(183) => 'a',
                chr(225) . chr(186) . chr(184) => 'E', chr(225) . chr(186) . chr(185) => 'e',
                chr(225) . chr(187) . chr(134) => 'E', chr(225) . chr(187) . chr(135) => 'e',
                chr(225) . chr(187) . chr(138) => 'I', chr(225) . chr(187) . chr(139) => 'i',
                chr(225) . chr(187) . chr(140) => 'O', chr(225) . chr(187) . chr(141) => 'o',
                chr(225) . chr(187) . chr(152) => 'O', chr(225) . chr(187) . chr(153) => 'o',
                chr(225) . chr(187) . chr(162) => 'O', chr(225) . chr(187) . chr(163) => 'o',
                chr(225) . chr(187) . chr(164) => 'U', chr(225) . chr(187) . chr(165) => 'u',
                chr(225) . chr(187) . chr(176) => 'U', chr(225) . chr(187) . chr(177) => 'u',
                chr(225) . chr(187) . chr(180) => 'Y', chr(225) . chr(187) . chr(181) => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                chr(201) . chr(145) => 'a',
                // macron
                chr(199) . chr(149) => 'U', chr(199) . chr(150) => 'u',
                // acute accent
                chr(199) . chr(151) => 'U', chr(199) . chr(152) => 'u',
                // caron
                chr(199) . chr(141) => 'A', chr(199) . chr(142) => 'a',
                chr(199) . chr(143) => 'I', chr(199) . chr(144) => 'i',
                chr(199) . chr(145) => 'O', chr(199) . chr(146) => 'o',
                chr(199) . chr(147) => 'U', chr(199) . chr(148) => 'u',
                chr(199) . chr(153) => 'U', chr(199) . chr(154) => 'u',
                // grave accent
                chr(199) . chr(155) => 'U', chr(199) . chr(156) => 'u',
            );

            // Used for locale-specific rules
            //$locale = get_locale();
            $locale = 'en_US';

            if ('de_DE' == $locale) {
                $chars[chr(195) . chr(132)] = 'Ae';
                $chars[chr(195) . chr(164)] = 'ae';
                $chars[chr(195) . chr(150)] = 'Oe';
                $chars[chr(195) . chr(182)] = 'oe';
                $chars[chr(195) . chr(156)] = 'Ue';
                $chars[chr(195) . chr(188)] = 'ue';
                $chars[chr(195) . chr(159)] = 'ss';
            }

            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                    . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                    . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                    . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                    . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                    . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                    . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                    . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                    . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                    . chr(252) . chr(253) . chr(255);

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }

    /**
     * Sanitizes a filename, replacing whitespace with dashes.
     *
     * Removes special characters that are illegal in filenames on certain
     * operating systems and special characters requiring special escaping
     * to manipulate at the command line. Replaces spaces and consecutive
     * dashes with a single dash. Trims period, dash and underscore from beginning
     * and end of filename.
     *
     * @since 1.0.0
     *
     * @param string $filename The filename to be sanitized
     * @return string The sanitized filename
     */
    public function sanitize_file_name($filename) {
        $filename_raw = $filename;
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
        $special_chars = $this->HuradHook->apply_filters('sanitize_file_name_chars', $special_chars, $filename_raw);
        $filename = str_replace($special_chars, '', $filename);
        $filename = preg_replace('/[\s-]+/', '-', $filename);
        $filename = trim($filename, '.-_');

        // Split the filename into a base and extension[s]
        $parts = explode('.', $filename);

        // Return if only one extension
        if (count($parts) <= 2)
            return $this->HuradHook->apply_filters('sanitize_file_name', $filename, $filename_raw);

        // Process multiple extensions
        $filename = array_shift($parts);
        $extension = array_pop($parts);
        $mimes = Functions::get_allowed_mime_types();

        // Loop over any intermediate extensions. Munge them with a trailing underscore if they are a 2 - 5 character
        // long alpha string not in the extension whitelist.
        foreach ((array) $parts as $part) {
            $filename .= '.' . $part;

            if (preg_match("/^[a-zA-Z]{2,5}\d?$/", $part)) {
                $allowed = false;
                foreach ($mimes as $ext_preg => $mime_match) {
                    $ext_preg = '!^(' . $ext_preg . ')$!i';
                    if (preg_match($ext_preg, $part)) {
                        $allowed = true;
                        break;
                    }
                }
                if (!$allowed)
                    $filename .= '_';
            }
        }
        $filename .= '.' . $extension;

        return $this->HuradHook->apply_filters('sanitize_file_name', $filename, $filename_raw);
    }

    /**
     * Sanitizes a username, stripping out unsafe characters.
     *
     * Removes tags, octets, entities, and if strict is enabled, will only keep
     * alphanumeric, _, space, ., -, @. After sanitizing, it passes the username,
     * raw username (the username in the parameter), and the value of $strict as
     * parameters for the 'sanitize_user' filter.
     *
     * @since 1.0.0
     * @uses apply_filters() Calls 'sanitize_user' hook on username, raw username,
     * and $strict parameter.
     *
     * @param string $username The username to be sanitized.
     * @param bool $strict If set limits $username to specific characters. Default false.
     * @return string The sanitized username, after passing through filters.
     */
    public function sanitize_user($username, $strict = false) {
        $raw_username = $username;
        $username = Formatting::hr_strip_all_tags($username);
        $username = Formatting::remove_accents($username);
        // Kill octets
        $username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
        $username = preg_replace('/&.+?;/', '', $username); // Kill entities
        // If strict, reduce to ASCII for max portability.
        if ($strict)
            $username = preg_replace('|[^a-z0-9 _.\-@]|i', '', $username);

        $username = trim($username);
        // Consolidate contiguous whitespace
        $username = preg_replace('|\s+|', ' ', $username);

        return $this->HuradHook->apply_filters('sanitize_user', $username, $raw_username, $strict);
    }

    /**
     * Sanitizes a string key.
     *
     * Keys are used as internal identifiers. Lowercase alphanumeric characters, dashes and underscores are allowed.
     *
     * @since 1.0.0
     *
     * @param string $key String key
     * @return string Sanitized key
     */
    public function sanitize_key($key) {
        $raw_key = $key;
        $key = strtolower($key);
        $key = preg_replace('/[^a-z0-9_\-]/', '', $key);
        return $this->HuradHook->apply_filters('sanitize_key', $key, $raw_key);
    }

    /**
     * Sanitizes a title, or returns a fallback title.
     *
     * Specifically, HTML and PHP tags are stripped. Further actions can be added
     * via the plugin API. If $title is empty and $fallback_title is set, the latter
     * will be used.
     *
     * @since 1.0.0
     *
     * @param string $title The string to be sanitized.
     * @param string $fallback_title Optional. A title to use if $title is empty.
     * @param string $context Optional. The operation for which the string is sanitized
     * @return string The sanitized string.
     */
    public function sanitize_title($title, $fallback_title = '', $context = 'save') {
        $raw_title = $title;

        if ('save' == $context)
            $title = Formatting::remove_accents($title);

        $title = $this->HuradHook->apply_filters('sanitize_title', $title, $raw_title, $context);

        if ('' === $title || false === $title)
            $title = $fallback_title;

        return $title;
    }

    /**
     * Sanitizes a title, replacing whitespace and a few other characters with dashes.
     *
     * Limits the output to alphanumeric characters, underscore (_) and dash (-).
     * Whitespace becomes a dash.
     *
     * @since 1.0.0
     *
     * @param string $title The title to be sanitized.
     * @param string $raw_title Optional. Not used.
     * @param string $context Optional. The operation for which the string is sanitized.
     * @return string The sanitized title.
     */
    public function sanitize_title_with_dashes($title, $raw_title = '', $context = 'display') {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

        if (Formatting::seems_utf8($title)) {
            if (function_exists('mb_strtolower')) {
                $title = mb_strtolower($title, 'UTF-8');
            }
            $title = Formatting::utf8_uri_encode($title, 200);
        }

        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);

        if ('save' == $context) {
            // Convert nbsp, ndash and mdash to hyphens
            $title = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), '-', $title);

            // Strip these characters entirely
            $title = str_replace(array(
                // iexcl and iquest
                '%c2%a1', '%c2%bf',
                // angle quotes
                '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
                // curly quotes
                '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
                '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
                // copy, reg, deg, hellip and trade
                '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
                // acute accents
                '%c2%b4', '%cb%8a', '%cc%81', '%cd%81',
                // grave accent, macron, caron
                '%cc%80', '%cc%84', '%cc%8c',
                    ), '', $title);

            // Convert times to x
            $title = str_replace('%c3%97', 'x', $title);
        }

        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');

        return $title;
    }

    /**
     * Sanitizes an HTML classname to ensure it only contains valid characters.
     *
     * Strips the string down to A-Z,a-z,0-9,_,-. If this results in an empty
     * string then it will return the alternative value supplied.
     *
     * @todo Expand to support the full range of CDATA that a class attribute can contain.
     *
     * @since 1.0.0
     *
     * @param string $class The classname to be sanitized
     * @param string $fallback Optional. The value to return if the sanitization end's up as an empty string.
     * Defaults to an empty string.
     * @return string The sanitized value
     */
    function sanitize_html_class($class, $fallback = '') {
        //Strip out any % encoded octets
        $sanitized = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|', '', $class);

        //Limit to A-Z,a-z,0-9,_,-
        $sanitized = preg_replace('/[^A-Za-z0-9_-]/', '', $sanitized);

        if ('' == $sanitized)
            $sanitized = $fallback;

        return Configure::read('HuradHook.obj')->apply_filters('sanitize_html_class', $sanitized, $class, $fallback);
    }

    /**
     * Converts a number of characters from a string.
     *
     * Metadata tags <<title>> and <<category>> are removed, <<br>> and <<hr>> are
     * converted into correct XHTML and Unicode characters are converted to the
     * valid range.
     *
     * @since 1.0.0
     *
     * @param string $content String of characters to be converted.
     * @return string Converted string.
     */
    function convert_chars($content) {
        // Translation of invalid Unicode references range to valid range
        $hr_htmltranswinuni = array(
            '&#128;' => '&#8364;', // the Euro sign
            '&#129;' => '',
            '&#130;' => '&#8218;', // these are Windows CP1252 specific characters
            '&#131;' => '&#402;', // they would look weird on non-Windows browsers
            '&#132;' => '&#8222;',
            '&#133;' => '&#8230;',
            '&#134;' => '&#8224;',
            '&#135;' => '&#8225;',
            '&#136;' => '&#710;',
            '&#137;' => '&#8240;',
            '&#138;' => '&#352;',
            '&#139;' => '&#8249;',
            '&#140;' => '&#338;',
            '&#141;' => '',
            '&#142;' => '&#381;',
            '&#143;' => '',
            '&#144;' => '',
            '&#145;' => '&#8216;',
            '&#146;' => '&#8217;',
            '&#147;' => '&#8220;',
            '&#148;' => '&#8221;',
            '&#149;' => '&#8226;',
            '&#150;' => '&#8211;',
            '&#151;' => '&#8212;',
            '&#152;' => '&#732;',
            '&#153;' => '&#8482;',
            '&#154;' => '&#353;',
            '&#155;' => '&#8250;',
            '&#156;' => '&#339;',
            '&#157;' => '',
            '&#158;' => '&#382;',
            '&#159;' => '&#376;'
        );

        // Remove metadata tags
        $content = preg_replace('/<title>(.+?)<\/title>/', '', $content);
        $content = preg_replace('/<category>(.+?)<\/category>/', '', $content);

        // Converts lone & characters into &#38; (a.k.a. &amp;)
        $content = preg_replace('/&([^#])(?![a-z1-4]{1,8};)/i', '&#038;$1', $content);

        // Fix Word pasting
        $content = strtr($content, $hr_htmltranswinuni);

        // Just a little XHTML help
        $content = str_replace('<br>', '<br />', $content);
        $content = str_replace('<hr>', '<hr />', $content);

        return $content;
    }

    /**
     * Balances tags if forced to, or if the 'use_balanceTags' option is set to true.
     *
     * @since 1.0.0
     *
     * @param string $text Text to be balanced
     * @param bool $force If true, forces balancing, ignoring the value of the option. Default false.
     * @return string Balanced text
     */
    public function balanceTags($text, $force = false) {
        if ($force || Configure::read('use_balanceTags') == 1)
            return Formatting::force_balance_tags($text);
        else
            return $text;
    }

    /**
     * Balances tags of string using a modified stack.
     *
     * @since 1.0.0
     *
     * @param string $text Text to be balanced.
     * @return string Balanced text.
     */
    public function force_balance_tags($text) {
        $tagstack = array();
        $stacksize = 0;
        $tagqueue = '';
        $newtext = '';
        // Known single-entity/self-closing tags
        $single_tags = array('area', 'base', 'basefont', 'br', 'col', 'command', 'embed', 'frame', 'hr', 'img', 'input', 'isindex', 'link', 'meta', 'param', 'source');
        // Tags that can be immediately nested within themselves
        $nestable_tags = array('blockquote', 'div', 'object', 'q', 'span');

        // HR bug fix for comments - in case you REALLY meant to type '< !--'
        $text = str_replace('< !--', '< !--', $text);
        // HR bug fix for LOVE <3 (and other situations with '<' before a number)
        $text = preg_replace('#<([0-9]{1})#', '&lt;$1', $text);

        while (preg_match("/<(\/?[\w:]*)\s*([^>]*)>/", $text, $regex)) {
            $newtext .= $tagqueue;

            $i = strpos($text, $regex[0]);
            $l = strlen($regex[0]);

            // clear the shifter
            $tagqueue = '';
            // Pop or Push
            if (isset($regex[1][0]) && '/' == $regex[1][0]) { // End Tag
                $tag = strtolower(substr($regex[1], 1));
                // if too many closing tags
                if ($stacksize <= 0) {
                    $tag = '';
                    // or close to be safe $tag = '/' . $tag;
                }
                // if stacktop value = tag close value then pop
                else if ($tagstack[$stacksize - 1] == $tag) { // found closing tag
                    $tag = '</' . $tag . '>'; // Close Tag
                    // Pop
                    array_pop($tagstack);
                    $stacksize--;
                } else { // closing tag not at top, search for it
                    for ($j = $stacksize - 1; $j >= 0; $j--) {
                        if ($tagstack[$j] == $tag) {
                            // add tag to tagqueue
                            for ($k = $stacksize - 1; $k >= $j; $k--) {
                                $tagqueue .= '</' . array_pop($tagstack) . '>';
                                $stacksize--;
                            }
                            break;
                        }
                    }
                    $tag = '';
                }
            } else { // Begin Tag
                $tag = strtolower($regex[1]);

                // Tag Cleaning
                // If it's an empty tag "< >", do nothing
                if ('' == $tag) {
                    // do nothing
                }
                // ElseIf it presents itself as a self-closing tag...
                elseif (substr($regex[2], -1) == '/') {
                    // ...but it isn't a known single-entity self-closing tag, then don't let it be treated as such and
                    // immediately close it with a closing tag (the tag will encapsulate no text as a result)
                    if (!in_array($tag, $single_tags))
                        $regex[2] = trim(substr($regex[2], 0, -1)) . "></$tag";
                }
                // ElseIf it's a known single-entity tag but it doesn't close itself, do so
                elseif (in_array($tag, $single_tags)) {
                    $regex[2] .= '/';
                }
                // Else it's not a single-entity tag
                else {
                    // If the top of the stack is the same as the tag we want to push, close previous tag
                    if ($stacksize > 0 && !in_array($tag, $nestable_tags) && $tagstack[$stacksize - 1] == $tag) {
                        $tagqueue = '</' . array_pop($tagstack) . '>';
                        $stacksize--;
                    }
                    $stacksize = array_push($tagstack, $tag);
                }

                // Attributes
                $attributes = $regex[2];
                if (!empty($attributes) && $attributes[0] != '>')
                    $attributes = ' ' . $attributes;

                $tag = '<' . $tag . $attributes . '>';
                //If already queuing a close tag, then put this tag on, too
                if (!empty($tagqueue)) {
                    $tagqueue .= $tag;
                    $tag = '';
                }
            }
            $newtext .= substr($text, 0, $i) . $tag;
            $text = substr($text, $i + $l);
        }

        // Clear Tag Queue
        $newtext .= $tagqueue;

        // Add Remaining text
        $newtext .= $text;

        // Empty Stack
        while ($x = array_pop($tagstack)) {
            $newtext .= '</' . $x . '>'; // Add remaining tags to close
        }

        // HR fix for the bug with HTML comments
        $newtext = str_replace("< !--", "<!--", $newtext);
        $newtext = str_replace("< !--", "< !--", $newtext);

        return $newtext;
    }

    /**
     * Acts on text which is about to be edited.
     *
     * The $content is run through esc_textarea(), which uses htmlspecialchars()
     * to convert special characters to HTML entities. If $richedit is set to true,
     * it is simply a holder for the 'format_to_edit' filter.
     *
     * @since 1.0.0
     *
     * @param string $content The text about to be edited.
     * @param bool $richedit Whether the $content should not pass through htmlspecialchars(). Default false (meaning it will be passed).
     * @return string The text after the filter (and possibly htmlspecialchars()) has been run.
     */
    public function format_to_edit($content, $richedit = false) {
        $content = $this->HuradHook->apply_filters('format_to_edit', $content);
        if (!$richedit)
            $content = Formatting::esc_textarea($content);
        return $content;
    }

    /**
     * Holder for the 'format_to_post' filter.
     *
     * @since 1.0.0
     *
     * @param string $content The text to pass through the filter.
     * @return string Text returned from the 'format_to_post' filter.
     */
    public function format_to_post($content) {
        $content = $this->HuradHook->apply_filters('format_to_post', $content);
        return $content;
    }

    /**
     * Add leading zeros when necessary.
     *
     * If you set the threshold to '4' and the number is '10', then you will get
     * back '0010'. If you set the threshold to '4' and the number is '5000', then you
     * will get back '5000'.
     *
     * Uses sprintf to append the amount of zeros based on the $threshold parameter
     * and the size of the number. If the number is large enough, then no zeros will
     * be appended.
     *
     * @since 1.0.0
     *
     * @param mixed $number Number to append zeros to if not greater than threshold.
     * @param int $threshold Digit places number needs to be to not have zeros added.
     * @return string Adds leading zeros to number if needed.
     */
    public function zeroise($number, $threshold) {
        return sprintf('%0' . $threshold . 's', $number);
    }

    /**
     * Adds backslashes before letters and before a number at the start of a string.
     *
     * @since 1.0.0
     *
     * @param string $string Value to which backslashes will be added.
     * @return string String with backslashes inserted.
     */
    public function backslashit($string) {
        $string = preg_replace('/^([0-9])/', '\\\\\\\\\1', $string);
        $string = preg_replace('/([a-z])/i', '\\\\\1', $string);
        return $string;
    }

    /**
     * Appends a trailing slash.
     *
     * Will remove trailing slash if it exists already before adding a trailing
     * slash. This prevents double slashing a string or path.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 1.0.0
     * @uses untrailingslashit() Unslashes string if it was slashed already.
     *
     * @param string $string What to add the trailing slash to.
     * @return string String with trailing slash added.
     */
    public function trailingslashit($string) {
        return Formatting::untrailingslashit($string) . '/';
    }

    /**
     * Removes trailing slash if it exists.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 1.0.0
     *
     * @param string $string What to remove the trailing slash from.
     * @return string String without the trailing slash.
     */
    public function untrailingslashit($string) {
        return rtrim($string, '/');
    }

    /**
     * Navigates through an array and removes slashes from the values.
     *
     * If an array is passed, the array_map() function causes a callback to pass the
     * value back to the function. The slashes from this value will removed.
     *
     * @since 1.0.0
     *
     * @param mixed $value The value to be stripped.
     * @return mixed Stripped value.
     */
    public function stripslashes_deep($value) {
        if (is_array($value)) {
            $value = array_map('Formatting::stripslashes_deep', $value);
        } elseif (is_object($value)) {
            $vars = get_object_vars($value);
            foreach ($vars as $key => $data) {
                $value->{$key} = Formatting::stripslashes_deep($data);
            }
        } elseif (is_string($value)) {
            $value = stripslashes($value);
        }

        return $value;
    }

    /**
     * Navigates through an array and encodes the values to be used in a URL.
     *
     *
     * @since 1.0.0
     *
     * @param array|string $value The array or string to be encoded.
     * @return array|string $value The encoded array (or string from the callback).
     */
    public function urlencode_deep($value) {
        $value = is_array($value) ? array_map('Formatting::urlencode_deep', $value) : urlencode($value);
        return $value;
    }

    /**
     * Navigates through an array and raw encodes the values to be used in a URL.
     *
     * @since 1.0.0
     *
     * @param array|string $value The array or string to be encoded.
     * @return array|string $value The encoded array (or string from the callback).
     */
    public function rawurlencode_deep($value) {
        return is_array($value) ? array_map('Formatting::rawurlencode_deep', $value) : rawurlencode($value);
    }

    /**
     * Callback to convert URI match to HTML A element.
     *
     * Regex callback for {@link make_clickable()}.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $matches Single Regex Match.
     * @return string HTML A element with URI address.
     */
    private function _make_url_clickable_cb($matches) {
        $url = $matches[2];

        if (')' == $matches[3] && strpos($url, '(')) {
            // If the trailing character is a closing parethesis, and the URL has an opening parenthesis in it, add the closing parenthesis to the URL.
            // Then we can let the parenthesis balancer do its thing below.
            $url .= $matches[3];
            $suffix = '';
        } else {
            $suffix = $matches[3];
        }

        // Include parentheses in the URL only if paired
        while (substr_count($url, '(') < substr_count($url, ')')) {
            $suffix = strrchr($url, ')') . $suffix;
            $url = substr($url, 0, strrpos($url, ')'));
        }

        $url = Formatting::esc_url($url);
        if (empty($url))
            return $matches[0];

        return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $suffix;
    }

    /**
     * Callback to convert URL match to HTML A element.
     *
     * Regex callback for {@link make_clickable()}.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $matches Single Regex Match.
     * @return string HTML A element with URL address.
     */
    private function _make_web_ftp_clickable_cb($matches) {
        $ret = '';
        $dest = $matches[2];
        $dest = 'http://' . $dest;
        $dest = Formatting::esc_url($dest);
        if (empty($dest))
            return $matches[0];

        // removed trailing [.,;:)] from URL
        if (in_array(substr($dest, -1), array('.', ',', ';', ':', ')')) === true) {
            $ret = substr($dest, -1);
            $dest = substr($dest, 0, strlen($dest) - 1);
        }
        return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>$ret";
    }

    /**
     * Callback to convert email address match to HTML A element.
     *
     * Regex callback for {@link make_clickable()}.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $matches Single Regex Match.
     * @return string HTML A element with email address.
     */
    private function _make_email_clickable_cb($matches) {
        $email = $matches[2] . '@' . $matches[3];
        return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }

    /**
     * Convert plaintext URI to HTML links.
     *
     * Converts URI, www and ftp, and email addresses. Finishes by fixing links
     * within links.
     *
     * @since 1.0.0
     *
     * @param string $text Content to convert URIs.
     * @return string Content with converted URIs.
     */
    public function make_clickable($text) {
        $r = '';
        $textarr = preg_split('/(<[^<>]+>)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE); // split out HTML tags
        foreach ($textarr as $piece) {
            if (empty($piece) || ( $piece[0] == '<' && !preg_match('|^<\s*[\w]{1,20}+://|', $piece) )) {
                $r .= $piece;
                continue;
            }

            // Long strings might contain expensive edge cases ...
            if (10000 < strlen($piece)) {
                // ... break it up
                foreach (Formatting::_split_str_by_whitespace($piece, 2100) as $chunk) { // 2100: Extra room for scheme and leading and trailing paretheses
                    if (2101 < strlen($chunk)) {
                        $r .= $chunk; // Too big, no whitespace: bail.
                    } else {
                        $r .= Formatting::make_clickable($chunk);
                    }
                }
            } else {
                $ret = " $piece "; // Pad with whitespace to simplify the regexes

                $url_clickable = '~
                                ([\\s(<.,;:!?]) # 1: Leading whitespace, or punctuation
                                ( # 2: URL
                                [\\w]{1,20}+:// # Scheme and hier-part prefix
                                (?=\S{1,2000}\s) # Limit to URLs less than about 2000 characters long
                                [\\w\\x80-\\xff#%\\~/@\\[\\]*(+=&$-]*+ # Non-punctuation URL character
                                (?: # Unroll the Loop: Only allow puctuation URL character if followed by a non-punctuation URL character
                                [\'.,;:!?)] # Punctuation URL character
                                [\\w\\x80-\\xff#%\\~/@\\[\\]*(+=&$-]++ # Non-punctuation URL character
                                )*
                                )
                                (\)?) # 3: Trailing closing parenthesis (for parethesis balancing post processing)
                                ~xS'; // The regex is a non-anchored pattern and does not have a single fixed starting character.
                // Tell PCRE to spend more time optimizing since, when used on a page load, it will probably be used several times.

                $ret = preg_replace_callback($url_clickable, 'Formatting::_make_url_clickable_cb', $ret);

                $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]+)#is', 'Formatting::_make_web_ftp_clickable_cb', $ret);
                $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', 'Formatting::_make_email_clickable_cb', $ret);

                $ret = substr($ret, 1, -1); // Remove our whitespace padding.
                $r .= $ret;
            }
        }

        // Cleanup of accidental links within links
        $r = preg_replace('#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i', "$1$3</a>", $r);
        return $r;
    }

    /**
     * Breaks a string into chunks by splitting at whitespace characters.
     * The length of each returned chunk is as close to the specified length goal as possible,
     * with the caveat that each chunk includes its trailing delimiter.
     * Chunks longer than the goal are guaranteed to not have any inner whitespace.
     *
     * Joining the returned chunks with empty delimiters reconstructs the input string losslessly.
     *
     * Input string must have no null characters (or eventual transformations on output chunks must not care about null characters)
     *
     * <code>
     * _split_str_by_whitespace( "1234 67890 1234 67890a cd 1234 890 123456789 1234567890a 45678 1 3 5 7 90 ", 10 ) ==
     * array (
     * 0 => '1234 67890 ', // 11 characters: Perfect split
     * 1 => '1234 ', // 5 characters: '1234 67890a' was too long
     * 2 => '67890a cd ', // 10 characters: '67890a cd 1234' was too long
     * 3 => '1234 890 ', // 11 characters: Perfect split
     * 4 => '123456789 ', // 10 characters: '123456789 1234567890a' was too long
     * 5 => '1234567890a ', // 12 characters: Too long, but no inner whitespace on which to split
     * 6 => ' 45678 ', // 11 characters: Perfect split
     * 7 => '1 3 5 7 9', // 9 characters: End of $string
     * );
     * </code>
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $string The string to split.
     * @param int $goal The desired chunk length.
     * @return array Numeric array of chunks.
     */
    private function _split_str_by_whitespace($string, $goal) {
        $chunks = array();

        $string_nullspace = strtr($string, "\r\n\t\v\f ", "\000\000\000\000\000\000");

        while ($goal < strlen($string_nullspace)) {
            $pos = strrpos(substr($string_nullspace, 0, $goal + 1), "\000");

            if (false === $pos) {
                $pos = strpos($string_nullspace, "\000", $goal + 1);
                if (false === $pos) {
                    break;
                }
            }

            $chunks[] = substr($string, 0, $pos + 1);
            $string = substr($string, $pos + 1);
            $string_nullspace = substr($string_nullspace, $pos + 1);
        }

        if ($string) {
            $chunks[] = $string;
        }

        return $chunks;
    }

    /**
     * Adds rel nofollow string to all HTML A elements in content.
     *
     * @since 1.0.0
     *
     * @param string $text Content that may contain HTML A elements.
     * @return string Converted content.
     */
    public function hr_rel_nofollow($text) {
        $text = preg_replace_callback('|<a (.+?)>|i', 'Formatting::hr_rel_nofollow_callback', $text);
        return $text;
    }

    /**
     * Callback to add rel=nofollow string to HTML A element.
     *
     * Will remove already existing rel="nofollow" and rel='nofollow' from the
     * string to prevent from invalidating (X)HTML.
     *
     * @since 1.0.0
     *
     * @param array $matches Single Match
     * @return string HTML A Element with rel nofollow.
     */
    public function hr_rel_nofollow_callback($matches) {
        $text = $matches[1];
        $text = str_replace(array(' rel="nofollow"', " rel='nofollow'"), '', $text);
        return "<a $text rel=\"nofollow\">";
    }

    /**
     * Converts named entities into numbered entities.
     *
     * @since 1.0.0
     *
     * @param string $text The text within which entities will be converted.
     * @return string Text with converted entities.
     */
    public function ent2ncr($text) {

        // Allow a plugin to short-circuit and override the mappings.
        $filtered = $this->HuradHook->apply_filters('pre_ent2ncr', null, $text);
        if (null !== $filtered)
            return $filtered;

        $to_ncr = array(
            '&quot;' => '&#34;',
            '&amp;' => '&#38;',
            '&frasl;' => '&#47;',
            '&lt;' => '&#60;',
            '&gt;' => '&#62;',
            '|' => '&#124;',
            '&nbsp;' => '&#160;',
            '&iexcl;' => '&#161;',
            '&cent;' => '&#162;',
            '&pound;' => '&#163;',
            '&curren;' => '&#164;',
            '&yen;' => '&#165;',
            '&brvbar;' => '&#166;',
            '&brkbar;' => '&#166;',
            '&sect;' => '&#167;',
            '&uml;' => '&#168;',
            '&die;' => '&#168;',
            '&copy;' => '&#169;',
            '&ordf;' => '&#170;',
            '&laquo;' => '&#171;',
            '&not;' => '&#172;',
            '&shy;' => '&#173;',
            '&reg;' => '&#174;',
            '&macr;' => '&#175;',
            '&hibar;' => '&#175;',
            '&deg;' => '&#176;',
            '&plusmn;' => '&#177;',
            '&sup2;' => '&#178;',
            '&sup3;' => '&#179;',
            '&acute;' => '&#180;',
            '&micro;' => '&#181;',
            '&para;' => '&#182;',
            '&middot;' => '&#183;',
            '&cedil;' => '&#184;',
            '&sup1;' => '&#185;',
            '&ordm;' => '&#186;',
            '&raquo;' => '&#187;',
            '&frac14;' => '&#188;',
            '&frac12;' => '&#189;',
            '&frac34;' => '&#190;',
            '&iquest;' => '&#191;',
            '&Agrave;' => '&#192;',
            '&Aacute;' => '&#193;',
            '&Acirc;' => '&#194;',
            '&Atilde;' => '&#195;',
            '&Auml;' => '&#196;',
            '&Aring;' => '&#197;',
            '&AElig;' => '&#198;',
            '&Ccedil;' => '&#199;',
            '&Egrave;' => '&#200;',
            '&Eacute;' => '&#201;',
            '&Ecirc;' => '&#202;',
            '&Euml;' => '&#203;',
            '&Igrave;' => '&#204;',
            '&Iacute;' => '&#205;',
            '&Icirc;' => '&#206;',
            '&Iuml;' => '&#207;',
            '&ETH;' => '&#208;',
            '&Ntilde;' => '&#209;',
            '&Ograve;' => '&#210;',
            '&Oacute;' => '&#211;',
            '&Ocirc;' => '&#212;',
            '&Otilde;' => '&#213;',
            '&Ouml;' => '&#214;',
            '&times;' => '&#215;',
            '&Oslash;' => '&#216;',
            '&Ugrave;' => '&#217;',
            '&Uacute;' => '&#218;',
            '&Ucirc;' => '&#219;',
            '&Uuml;' => '&#220;',
            '&Yacute;' => '&#221;',
            '&THORN;' => '&#222;',
            '&szlig;' => '&#223;',
            '&agrave;' => '&#224;',
            '&aacute;' => '&#225;',
            '&acirc;' => '&#226;',
            '&atilde;' => '&#227;',
            '&auml;' => '&#228;',
            '&aring;' => '&#229;',
            '&aelig;' => '&#230;',
            '&ccedil;' => '&#231;',
            '&egrave;' => '&#232;',
            '&eacute;' => '&#233;',
            '&ecirc;' => '&#234;',
            '&euml;' => '&#235;',
            '&igrave;' => '&#236;',
            '&iacute;' => '&#237;',
            '&icirc;' => '&#238;',
            '&iuml;' => '&#239;',
            '&eth;' => '&#240;',
            '&ntilde;' => '&#241;',
            '&ograve;' => '&#242;',
            '&oacute;' => '&#243;',
            '&ocirc;' => '&#244;',
            '&otilde;' => '&#245;',
            '&ouml;' => '&#246;',
            '&divide;' => '&#247;',
            '&oslash;' => '&#248;',
            '&ugrave;' => '&#249;',
            '&uacute;' => '&#250;',
            '&ucirc;' => '&#251;',
            '&uuml;' => '&#252;',
            '&yacute;' => '&#253;',
            '&thorn;' => '&#254;',
            '&yuml;' => '&#255;',
            '&OElig;' => '&#338;',
            '&oelig;' => '&#339;',
            '&Scaron;' => '&#352;',
            '&scaron;' => '&#353;',
            '&Yuml;' => '&#376;',
            '&fnof;' => '&#402;',
            '&circ;' => '&#710;',
            '&tilde;' => '&#732;',
            '&Alpha;' => '&#913;',
            '&Beta;' => '&#914;',
            '&Gamma;' => '&#915;',
            '&Delta;' => '&#916;',
            '&Epsilon;' => '&#917;',
            '&Zeta;' => '&#918;',
            '&Eta;' => '&#919;',
            '&Theta;' => '&#920;',
            '&Iota;' => '&#921;',
            '&Kappa;' => '&#922;',
            '&Lambda;' => '&#923;',
            '&Mu;' => '&#924;',
            '&Nu;' => '&#925;',
            '&Xi;' => '&#926;',
            '&Omicron;' => '&#927;',
            '&Pi;' => '&#928;',
            '&Rho;' => '&#929;',
            '&Sigma;' => '&#931;',
            '&Tau;' => '&#932;',
            '&Upsilon;' => '&#933;',
            '&Phi;' => '&#934;',
            '&Chi;' => '&#935;',
            '&Psi;' => '&#936;',
            '&Omega;' => '&#937;',
            '&alpha;' => '&#945;',
            '&beta;' => '&#946;',
            '&gamma;' => '&#947;',
            '&delta;' => '&#948;',
            '&epsilon;' => '&#949;',
            '&zeta;' => '&#950;',
            '&eta;' => '&#951;',
            '&theta;' => '&#952;',
            '&iota;' => '&#953;',
            '&kappa;' => '&#954;',
            '&lambda;' => '&#955;',
            '&mu;' => '&#956;',
            '&nu;' => '&#957;',
            '&xi;' => '&#958;',
            '&omicron;' => '&#959;',
            '&pi;' => '&#960;',
            '&rho;' => '&#961;',
            '&sigmaf;' => '&#962;',
            '&sigma;' => '&#963;',
            '&tau;' => '&#964;',
            '&upsilon;' => '&#965;',
            '&phi;' => '&#966;',
            '&chi;' => '&#967;',
            '&psi;' => '&#968;',
            '&omega;' => '&#969;',
            '&thetasym;' => '&#977;',
            '&upsih;' => '&#978;',
            '&piv;' => '&#982;',
            '&ensp;' => '&#8194;',
            '&emsp;' => '&#8195;',
            '&thinsp;' => '&#8201;',
            '&zwnj;' => '&#8204;',
            '&zwj;' => '&#8205;',
            '&lrm;' => '&#8206;',
            '&rlm;' => '&#8207;',
            '&ndash;' => '&#8211;',
            '&mdash;' => '&#8212;',
            '&lsquo;' => '&#8216;',
            '&rsquo;' => '&#8217;',
            '&sbquo;' => '&#8218;',
            '&ldquo;' => '&#8220;',
            '&rdquo;' => '&#8221;',
            '&bdquo;' => '&#8222;',
            '&dagger;' => '&#8224;',
            '&Dagger;' => '&#8225;',
            '&bull;' => '&#8226;',
            '&hellip;' => '&#8230;',
            '&permil;' => '&#8240;',
            '&prime;' => '&#8242;',
            '&Prime;' => '&#8243;',
            '&lsaquo;' => '&#8249;',
            '&rsaquo;' => '&#8250;',
            '&oline;' => '&#8254;',
            '&frasl;' => '&#8260;',
            '&euro;' => '&#8364;',
            '&image;' => '&#8465;',
            '&weierp;' => '&#8472;',
            '&real;' => '&#8476;',
            '&trade;' => '&#8482;',
            '&alefsym;' => '&#8501;',
            '&crarr;' => '&#8629;',
            '&lArr;' => '&#8656;',
            '&uArr;' => '&#8657;',
            '&rArr;' => '&#8658;',
            '&dArr;' => '&#8659;',
            '&hArr;' => '&#8660;',
            '&forall;' => '&#8704;',
            '&part;' => '&#8706;',
            '&exist;' => '&#8707;',
            '&empty;' => '&#8709;',
            '&nabla;' => '&#8711;',
            '&isin;' => '&#8712;',
            '&notin;' => '&#8713;',
            '&ni;' => '&#8715;',
            '&prod;' => '&#8719;',
            '&sum;' => '&#8721;',
            '&minus;' => '&#8722;',
            '&lowast;' => '&#8727;',
            '&radic;' => '&#8730;',
            '&prop;' => '&#8733;',
            '&infin;' => '&#8734;',
            '&ang;' => '&#8736;',
            '&and;' => '&#8743;',
            '&or;' => '&#8744;',
            '&cap;' => '&#8745;',
            '&cup;' => '&#8746;',
            '&int;' => '&#8747;',
            '&there4;' => '&#8756;',
            '&sim;' => '&#8764;',
            '&cong;' => '&#8773;',
            '&asymp;' => '&#8776;',
            '&ne;' => '&#8800;',
            '&equiv;' => '&#8801;',
            '&le;' => '&#8804;',
            '&ge;' => '&#8805;',
            '&sub;' => '&#8834;',
            '&sup;' => '&#8835;',
            '&nsub;' => '&#8836;',
            '&sube;' => '&#8838;',
            '&supe;' => '&#8839;',
            '&oplus;' => '&#8853;',
            '&otimes;' => '&#8855;',
            '&perp;' => '&#8869;',
            '&sdot;' => '&#8901;',
            '&lceil;' => '&#8968;',
            '&rceil;' => '&#8969;',
            '&lfloor;' => '&#8970;',
            '&rfloor;' => '&#8971;',
            '&lang;' => '&#9001;',
            '&rang;' => '&#9002;',
            '&larr;' => '&#8592;',
            '&uarr;' => '&#8593;',
            '&rarr;' => '&#8594;',
            '&darr;' => '&#8595;',
            '&harr;' => '&#8596;',
            '&loz;' => '&#9674;',
            '&spades;' => '&#9824;',
            '&clubs;' => '&#9827;',
            '&hearts;' => '&#9829;',
            '&diams;' => '&#9830;'
        );

        return str_replace(array_keys($to_ncr), array_values($to_ncr), $text);
    }

    /**
     * Formats text for the rich text editor.
     *
     * The filter 'richedit_pre' is applied here. If $text is empty the filter will
     * be applied to an empty string.
     *
     * @since 1.0.0
     *
     * @param string $text The text to be formatted.
     * @return string The formatted text after filter is applied.
     */
    public function hr_richedit_pre($text) {
        // Filtering a blank results in an annoying <br />\n
        if (empty($text))
            return $this->HuradHook->apply_filters('richedit_pre', '');

        $output = Formatting::convert_chars($text);
        $output = Formatting::hrautop($output);
        $output = htmlspecialchars($output, ENT_NOQUOTES);

        return $this->HuradHook->apply_filters('richedit_pre', $output);
    }

    /**
     * Formats text for the HTML editor.
     *
     * Unless $output is empty it will pass through htmlspecialchars before the
     * 'htmledit_pre' filter is applied.
     *
     * @since 1.0.0
     *
     * @param string $output The text to be formatted.
     * @return string Formatted text after filter applied.
     */
    public function hr_htmledit_pre($output) {
        if (!empty($output))
            $output = htmlspecialchars($output, ENT_NOQUOTES); // convert only < > &

        return $this->HuradHook->apply_filters('htmledit_pre', $output);
    }

    /**
     * Perform a deep string replace operation to ensure the values in $search are no longer present
     *
     * Repeats the replacement operation until it no longer replaces anything so as to remove "nested" values
     * e.g. $subject = '%0%0%0DDD', $search ='%0D', $result ='' rather than the '%0%0DD' that
     * str_replace would return
     *
     * @since 1.0.0
     * @access private
     *
     * @param string|array $search
     * @param string $subject
     * @return string The processed string
     */
    private function _deep_replace($search, $subject) {
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
     * Checks and cleans a URL.
     *
     * A number of characters are removed from the URL. If the URL is for displaying
     * (the default behaviour) ampersands are also replaced. The 'clean_url' filter
     * is applied to the returned cleaned URL.
     *
     * @since 1.0.0
     * @uses kses_bad_protocol() To only permit protocols in the URL set
     * via $protocols or the common ones set in the function.
     *
     * @param string $url The URL to be cleaned.
     * @param array $protocols Optional. An array of acceptable protocols.
     * Defaults to 'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn' if not set.
     * @param string $_context Private. Use esc_url_raw() for database usage.
     * @return string The cleaned $url after the 'clean_url' filter is applied.
     */
    public function esc_url($url, $protocols = null, $_context = 'display') {
        $original_url = $url;

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
            $protocols = Functions::allowed_protocols();
        $good_protocol_url = kses_bad_protocol($url, $protocols);
        if (strtolower($good_protocol_url) != strtolower($url))
            return '';

        return Configure::read('HuradHook.obj')->apply_filters('clean_url', $good_protocol_url, $original_url, $_context);
    }

    /**
     * Convert entities, while preserving already-encoded entities.
     *
     * @link http://www.php.net/htmlentities Borrowed from the PHP Manual user notes.
     *
     * @since 1.0.0
     *
     * @param string $myHTML The text to be converted.
     * @return string Converted text.
     */
    public function htmlentities2($myHTML) {
        $translation_table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        $translation_table[chr(38)] = '&';
        return preg_replace("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/", "&amp;", strtr($myHTML, $translation_table));
    }

    /**
     * Escape single quotes, htmlspecialchar " < > &, and fix line endings.
     *
     * Escapes text strings for echoing in JS. It is intended to be used for inline JS
     * (in a tag attribute, for example onclick="..."). Note that the strings have to
     * be in single quotes. The filter 'js_escape' is also applied here.
     *
     * @since 1.0.0
     *
     * @param string $text The text to be escaped.
     * @return string Escaped text.
     */
    public function esc_js($text) {
        $safe_text = Formatting::hr_check_invalid_utf8($text);
        $safe_text = Formatting::_hr_specialchars($safe_text, ENT_COMPAT);
        $safe_text = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe_text));
        $safe_text = str_replace("\r", '', $safe_text);
        $safe_text = str_replace("\n", '\\n', addslashes($safe_text));
        return Configure::read('HuradHook.obj')->apply_filters('js_escape', $safe_text, $text);
    }

    /**
     * Escaping for HTML blocks.
     *
     * @since 1.0.0
     *
     * @param string $text
     * @return string
     */
    public function esc_html($text) {
        $safe_text = Formatting::hr_check_invalid_utf8($text);
        $safe_text = Formatting::_hr_specialchars($safe_text, ENT_QUOTES);
        return Configure::read('HuradHook.obj')->apply_filters('esc_html', $safe_text, $text);
    }

    /**
     * Escaping for HTML attributes.
     *
     * @since 1.0.0
     *
     * @param string $text
     * @return string
     */
    public function esc_attr($text) {
        $safe_text = Formatting::hr_check_invalid_utf8($text);
        $safe_text = Formatting::_hr_specialchars($safe_text, ENT_QUOTES);
        return Configure::read('HuradHook.obj')->apply_filters('attribute_escape', $safe_text, $text);
    }

    /**
     * Sanitize a string from user input or from the db
     *
     * check for invalid UTF-8,
     * Convert single < characters to entity,
     * strip all tags,
     * remove line breaks, tabs and extra white space,
     * strip octets.
     *
     * @since 1.0.0
     *
     * @param string $str
     * @return string
     */
    public function sanitize_text_field($str) {
        $filtered = Formatting::hr_check_invalid_utf8($str);

        if (strpos($filtered, '<') !== false) {
            $filtered = Formatting::hr_pre_kses_less_than($filtered);
            // This will strip extra whitespace for us.
            $filtered = Formatting::hr_strip_all_tags($filtered, true);
        } else {
            $filtered = trim(preg_replace('/[\r\n\t ]+/', ' ', $filtered));
        }

        $match = array();
        $found = false;
        while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
            $filtered = str_replace($match[0], '', $filtered);
            $found = true;
        }

        if ($found) {
            // Strip out the whitespace that may now exist after removing the octets.
            $filtered = trim(preg_replace('/ +/', ' ', $filtered));
        }

        return $this->HuradHook->apply_filters('sanitize_text_field', $filtered, $str);
    }

    /**
     * Convert lone less than signs.
     *
     * KSES already converts lone greater than signs.
     *
     * @uses hr_pre_kses_less_than_callback in the callback function.
     * @since 1.0.0
     *
     * @param string $text Text to be converted.
     * @return string Converted text.
     */
    public function hr_pre_kses_less_than($text) {
        return preg_replace_callback('%<[^>]*?((?=<)|>|$)%', 'Formatting::hr_pre_kses_less_than_callback', $text);
    }

    /**
     * Callback function used by preg_replace.
     *
     * @uses esc_html to format the $matches text.
     * @since 1.0.0
     *
     * @param array $matches Populated by matches to preg_replace.
     * @return string The text returned after esc_html if needed.
     */
    public function hr_pre_kses_less_than_callback($matches) {
        if (false === strpos($matches[0], '>'))
            return Formatting::esc_html($matches[0]);
        return $matches[0];
    }

    /**
     * Hurad implementation of PHP sprintf() with filters.
     *
     * @since 1.0.0
     * @link http://www.php.net/sprintf
     *
     * @param string $pattern The string which formatted args are inserted.
     * @param mixed $args,... Arguments to be formatted into the $pattern string.
     * @return string The formatted string.
     */
    public function hr_sprintf($pattern) {
        $args = func_get_args();
        $len = strlen($pattern);
        $start = 0;
        $result = '';
        $arg_index = 0;
        while ($len > $start) {
            // Last character: append and break
            if (strlen($pattern) - 1 == $start) {
                $result .= substr($pattern, -1);
                break;
            }

            // Literal %: append and continue
            if (substr($pattern, $start, 2) == '%%') {
                $start += 2;
                $result .= '%';
                continue;
            }

            // Get fragment before next %
            $end = strpos($pattern, '%', $start + 1);
            if (false === $end)
                $end = $len;
            $fragment = substr($pattern, $start, $end - $start);

            // Fragment has a specifier
            if ($pattern[$start] == '%') {
                // Find numbered arguments or take the next one in order
                if (preg_match('/^%(\d+)\$/', $fragment, $matches)) {
                    $arg = isset($args[$matches[1]]) ? $args[$matches[1]] : '';
                    $fragment = str_replace("%{$matches[1]}$", '%', $fragment);
                } else {
                    ++$arg_index;
                    $arg = isset($args[$arg_index]) ? $args[$arg_index] : '';
                }

                // Apply filters OR sprintf
                $_fragment = apply_filters('wp_sprintf', $fragment, $arg);
                if ($_fragment != $fragment)
                    $fragment = $_fragment;
                else
                    $fragment = sprintf($fragment, strval($arg));
            }

            // Append to result and move to next fragment
            $result .= $fragment;
            $start = $end;
        }
        return $result;
    }

    /**
     * Localize list items before the rest of the content.
     *
     * The '%l' must be at the first characters can then contain the rest of the
     * content. The list items will have ', ', ', and', and ' and ' added depending
     * on the amount of list items in the $args parameter.
     *
     * @since 1.0.0
     *
     * @param string $pattern Content containing '%l' at the beginning.
     * @param array $args List items to prepend to the content and replace '%l'.
     * @return string Localized list items and rest of the content.
     */
    public function hr_sprintf_l($pattern, $args) {
        // Not a match
        if (substr($pattern, 0, 2) != '%l')
            return $pattern;

        // Nothing to work with
        if (empty($args))
            return '';

        // Translate and filter the delimiter set (avoid ampersands and entities here)
        $l = $this->HuradHook->apply_filters('hr_sprintf_l', array(
            /* translators: used between list items, there is a space after the comma */
            'between' => __(', '),
            /* translators: used between list items, there is a space after the and */
            'between_last_two' => __(', and '),
            /* translators: used between only two list items, there is a space after the and */
            'between_only_two' => __(' and '),
        ));

        $args = (array) $args;
        $result = array_shift($args);
        if (count($args) == 1)
            $result .= $l['between_only_two'] . array_shift($args);
        // Loop when more than two args
        $i = count($args);
        while ($i) {
            $arg = array_shift($args);
            $i--;
            if (0 == $i)
                $result .= $l['between_last_two'] . $arg;
            else
                $result .= $l['between'] . $arg;
        }
        return $result . substr($pattern, 2);
    }

    /**
     * Safely extracts not more than the first $count characters from html string.
     *
     * UTF-8, tags and entities safe prefix extraction. Entities inside will *NOT*
     * be counted as one character. For example &amp; will be counted as 4, &lt; as
     * 3, etc.
     *
     * @since 1.0.0
     *
     * @param integer $str String to get the excerpt from.
     * @param integer $count Maximum number of characters to take.
     * @return string The excerpt.
     */
    public function hr_html_excerpt($str, $count) {
        $str = Formatting::hr_strip_all_tags($str, true);
        $str = mb_substr($str, 0, $count);
        // remove part of an entity at the end
        $str = preg_replace('/&[^;\s]{0,6}$/', '', $str);
        return $str;
    }

    /**
     * Adds a Target attribute to all links in passed content.
     *
     * This function by default only applies to <a> tags, however this can be
     * modified by the 3rd param.
     *
     * <b>NOTE:</b> Any current target attributed will be stripped and replaced.
     *
     * @since 1.0.0
     *
     * @param string $content String to search for links in.
     * @param string $target The Target to add to the links.
     * @param array $tags An array of tags to apply to.
     * @return string The processed content.
     */
    public function links_add_target($content, $target = '_blank', $tags = array('a')) {
        global $_links_add_target;
        $_links_add_target = $target;
        $tags = implode('|', (array) $tags);
        return preg_replace_callback("!<($tags)(.+?)>!i", 'Formatting::_links_add_target', $content);
    }

    /**
     * Callback to add a target attribute to all links in passed content.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $m The matched link.
     * @return string The processed link.
     */
    private function _links_add_target($m) {
        global $_links_add_target;
        $tag = $m[1];
        $link = preg_replace('|(target=[\'"](.*?)[\'"])|i', '', $m[2]);
        return '<' . $tag . $link . ' target="' . Formatting::esc_attr($_links_add_target) . '">';
    }

    /**
     * Normalize EOL characters and strip duplicate whitespace.
     *
     * @since 1.0.0
     *
     * @param string $str The string to normalize.
     * @return string The normalized string.
     */
    public function normalize_whitespace($str) {
        $str = trim($str);
        $str = str_replace("\r", "\n", $str);
        $str = preg_replace(array('/\n+/', '/[ \t]+/'), array("\n", ' '), $str);
        return $str;
    }

    /**
     * Properly strip all HTML tags including script and style
     *
     * @since 1.0.0
     *
     * @param string $string String containing HTML tags
     * @param bool $remove_breaks optional Whether to remove left over line breaks and white space chars
     * @return string The processed string.
     */
    public function hr_strip_all_tags($string, $remove_breaks = false) {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);

        if ($remove_breaks)
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);

        return trim($string);
    }

}