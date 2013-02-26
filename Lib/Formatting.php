<?php

App::import('Vendor', 'kses');

/**
 * Description of Formatting
 *
 * @author mohammad
 */
class Formatting {

    public function __construct() {
        $this->HuradHook = Configure::read('HuradHook.obj');
        ;
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
     * Balances tags of string using a modified stack.
     *
     * @since 1.0.0
     *
     * @param string $text Text to be balanced.
     * @return string Balanced text.
     */
    function force_balance_tags($text) {
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
        while ($x = array_pop($tagstack))
            $newtext .= '</' . $x . '>'; // Add remaining tags to close

            
// HR fix for the bug with HTML comments
        $newtext = str_replace("< !--", "<!--", $newtext);
        $newtext = str_replace("< !--", "< !--", $newtext);

        return $newtext;
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
    function sanitize_title($title, $fallback_title = '', $context = 'save') {
        $raw_title = $title;

        if ('save' == $context)
            $title = $this->remove_accents($title);

        $title = $this->HuradHook->apply_filters('sanitize_title', $title, $raw_title, $context);

        if ('' === $title || false === $title)
            $title = $fallback_title;

        return $title;
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
    function remove_accents($string) {
        if (!preg_match('/[\x80-\xff]/', $string))
            return $string;

        if ($this->seems_utf8($string)) {
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
     * Checks to see if a string is utf8 encoded.
     *
     * NOTE: This function checks for 5-Byte sequences, UTF8
     * has Bytes Sequences with a maximum length of 4.
     *
     * @author bmorel at ssi dot fr (modified)
     * @since 1.0.0
     *
     * @param string $str The string to be checked
     * @return bool True if $str fits a UTF-8 model, false otherwise.
     */
    function seems_utf8($str) {
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
            $protocols = Functions::allowed_protocols();
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
     * @since 1.0
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
     * @since 1.0
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
     * @since 1.0
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

    /**
     * Appends a trailing slash.
     *
     * Will remove trailing slash if it exists already before adding a trailing
     * slash. This prevents double slashing a string or path.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 1.2.0
     * @uses untrailingslashit() Unslashes string if it was slashed already.
     *
     * @param string $string What to add the trailing slash to.
     * @return string String with trailing slash added.
     */
    function trailingslashit($string) {
        return $this->untrailingslashit($string) . '/';
    }

    /**
     * Removes trailing slash if it exists.
     *
     * The primary use of this is for paths and thus should be used for paths. It is
     * not restricted to paths and offers no specific path support.
     *
     * @since 2.2.0
     *
     * @param string $string What to remove the trailing slash from.
     * @return string String without the trailing slash.
     */
    function untrailingslashit($string) {
        return rtrim($string, '/');
    }

}