<?php

/**
 * Retrieve a list of protocols to allow in HTML attributes.
 *
 * @since 3.3.0
 * @see wp_kses()
 * @see esc_url()
 *
 * @return array Array of allowed protocols
 */
function allowed_protocols() {
    static $protocols;

    if (empty($protocols)) {
        $protocols = array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'svn');
    }

    return $protocols;
}

/**
 * Determine if SSL is used.
 *
 * @since 1.0.0
 *
 * @return bool True if SSL, false if not used.
 */
function is_ssl() {
    if (isset($_SERVER['HTTPS'])) {
        if ('on' == strtolower($_SERVER['HTTPS']))
            return true;
        if ('1' == $_SERVER['HTTPS'])
            return true;
    } elseif (isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

/**
 * Whether the current request is for a network or blog admin page
 *
 * Does not inform on whether the user is an admin! Use capability checks to
 * tell if the user should be accessing a section or not.
 *
 * @since 1.0.0
 *
 * @return bool True if inside Hurad administration pages.
 */
function is_admin() {
    $pos = strpos($_SERVER['REQUEST_URI'], 'admin');

    if ($pos === false) {
        return FALSE;
    } else {
        return TRUE;
    }
}