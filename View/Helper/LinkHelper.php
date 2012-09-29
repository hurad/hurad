<?php
App::import('Lib', 'Functions');
/**
 * Description of LinkHelper
 *
 * @author mohammad
 */
class LinkHelper extends AppHelper {

    /**
     * Print the home url for the current site.
     *
     * Returns the 'home' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @uses get_home_url()
     *
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    function home_url($path = '', $scheme = null) {
        echo $this->get_home_url($path, $scheme);
    }

    /**
     * Retrieve the home url for a given site.
     *
     * Returns the 'home' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    function get_home_url($path = '', $scheme = null) {

        if (!in_array($scheme, array('http', 'https', 'relative'))) {
            $scheme = is_ssl() && !is_admin() ? 'https' : 'http';
        }

        $url = Configure::read('General-site_url');

        if ('relative' == $scheme)
            $url = preg_replace('#^.+://[^/]*#', '', $url);
        elseif ('http' != $scheme)
            $url = str_replace('http://', "$scheme://", $url);

        if (!empty($path) && is_string($path) && strpos($path, '..') === false)
            $url .= '/' . ltrim($path, '/');

        return $url;
    }

    /**
     * Print the url to the admin area for the current site.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use.
     * @return string Admin url link with optional path appended.
     */
    function admin_url($path = '', $scheme = null) {
        return $this->get_admin_url($path, $scheme);
    }

    /**
     * Retrieve the url to the admin area for a given site.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use.
     * @return string Admin url link with optional path appended.
     */
    function get_admin_url($path = '', $scheme = null) {
        $url = $this->get_site_url('admin/', $scheme);

        if (!empty($path) && is_string($path) && strpos($path, '..') === false)
            $url .= ltrim($path, '/');

        return $url;
    }

    /**
     * Print the site url for the current site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @uses get_site_url()
     *
     * @param string $path Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. Currently 'http', 'https', 'relative'.
     * @return string Site url link with optional path appended.
     */
    function site_url($path = '', $scheme = null) {
        echo $this->get_site_url($path, $scheme);
    }

    /**
     * Retrieve the site url for a given site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @package Hurad
     * @since 1.0.0
     *
     * @param string $path Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. Currently 'http', 'https', 'relative'.
     * @return string Site url link with optional path appended.
     */
    function get_site_url($path = '', $scheme = null) {
        if (!in_array($scheme, array('http', 'https', 'relative'))) {
            $scheme = ( is_ssl() ? 'https' : 'http' );
        }

        $url = Configure::read('General-site_url');

        if ('relative' == $scheme)
            $url = preg_replace('#^.+://[^/]*#', '', $url);
        elseif ('http' != $scheme)
            $url = str_replace('http://', "{$scheme}://", $url);

        if (!empty($path) && is_string($path) && strpos($path, '..') === false)
            $url .= '/' . ltrim($path, '/');

        return $url;
    }

}

?>
