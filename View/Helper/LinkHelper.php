<?php

App::uses('AppHelper', 'View/Helper');

/**
 * LinkHelper
 * 
 * @copyright (c) 2006-2013, WordPress Link Template Functions
 *
 * @since 1.0.0
 */
class LinkHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Time', 'Hook');

    /**
     * Current post array
     *
     * @var array
     * @access public
     */
    public $post = array();

    /**
     * Display the permalink for the current post.
     *
     * @since 1.0.0
     * @uses apply_filters() Calls 'the_permalink' filter on the permalink string.
     */
    function thePermalink() {
        echo $this->Hook->applyFilters('the_permalink', $this->getPermalink());
    }

    /**
     * Display permalink anchor for current post.
     *
     * The permalink mode title will use the post title for the 'a' element 'id'
     * attribute. The id mode uses 'post-' with the post ID for the 'id' attribute.
     *
     * @since 1.0.0
     *
     * @param string $mode Permalink mode can be either 'title', 'id', or default, which is 'id'.
     */
    function permalinkAnchor($mode = 'id') {
        switch (strtolower($mode)) {
            case 'title':
                $title = Formatting::sanitize_title($this->post['Post']['title']) . '-' . $post->ID;
                echo '<a id="' . $title . '"></a>';
                break;
            case 'id':
            default:
                echo '<a id="post-' . $this->post['Post']['id'] . '"></a>';
                break;
        }
    }

    /**
     * Retrieve full permalink for current post.
     *
     * @since 1.0.0
     *
     * @return string
     */
    function getPermalink() {
        $year = $this->Time->format('Y', $this->post['Post']['created']);
        $month = $this->Time->format('m', $this->post['Post']['created']);
        $day = $this->Time->format('d', $this->post['Post']['created']);
        if ($this->post['Post']['type'] == 'post') {
            switch (Configure::read('Permalink.common')) {
                case 'default':
                    $permalink = $this->Html->url(Configure::read('General.site_url') . "/p/" . $this->post['Post']['id']);
                    break;
                case 'day_name':
                    $permalink = $this->Html->url(Configure::read('General.site_url') . "/" . $year . "/" . $month . "/" . $day . "/" . $this->post['Post']['slug']);
                    break;
                case 'month_name':
                    $permalink = $this->Html->url(Configure::read('General.site_url') . "/" . $year . "/" . $month . "/" . $this->post['Post']['slug']);
                    break;
                default:
                    break;
            }
        } elseif ($this->post['Post']['type'] == 'page') {
            if (Configure::read('Permalink.common') == 'default') {
                $permalink = $this->Html->url(Configure::read('General.site_url') . "/page/" . $this->post['Post']['id']);
            } else {
                $permalink = $this->Html->url(Configure::read('General.site_url') . "/page/" . $this->post['Post']['slug']);
            }
        }
        return $this->Hook->applyFilters('post_link', $permalink);
    }

    /**
     * Retrieve the home url for the current site.
     *
     * Returns the 'home' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 1.0.0
     *
     * @uses getHomeUrl()
     *
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    public function homeUrl($path = '', $scheme = null) {
        return $this->getHomeUrl($path, $scheme);
    }

    /**
     * Retrieve the home url for a given site.
     *
     * Returns the 'home' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 1.0.0
     *
     * @param  string $path   (optional) Path relative to the home url.
     * @param  string $scheme (optional) Scheme to give the home url context. Currently 'http', 'https', or 'relative'.
     * @return string Home url link with optional path appended.
     */
    public function getHomeUrl($path = '', $scheme = null) {
        $orig_scheme = $scheme;

        $url = Configure::read('General.home_url');

        if (!in_array($scheme, array('http', 'https', 'relative'))) {
            if (Functions::is_ssl() && !Functions::is_admin())
                $scheme = 'https';
            else
                $scheme = parse_url($url, PHP_URL_SCHEME);
        }

        $url = $this->setUrlScheme($url, $scheme);

        if (!empty($path) && is_string($path) && strpos($path, '..') === false)
            $url .= '/' . ltrim($path, '/');

        return $this->Hook->applyFilters('home_url', $url, $path, $orig_scheme);
    }

    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @since 1.0.0
     * @uses getAdminUrl()
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public function adminUrl($path = '', $scheme = 'admin') {
        return $this->getAdminUrl($path, $scheme);
    }

    /**
     * Retrieve the url to the admin area for a given site.
     *
     * @since 1.0.0
     * @uses getSiteUrl()
     *
     * @param string $path Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     * @return string Admin url link with optional path appended.
     */
    public function getAdminUrl($path = '', $scheme = 'admin') {
        $url = $this->getSiteUrl('admin/', $scheme);

        if ($path && is_string($path))
            $url .= ltrim($path, '/');

        return $this->Hook->applyFilters('admin_url', $url, $path);
    }

    /**
     * Retrieve the site url for the current site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 1.0.0
     *
     * @uses getSiteUrl()
     *
     * @param string $path Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. See set_url_scheme().
     * @return string Site url link with optional path appended.
     */
    public function siteUrl($path = '', $scheme = null) {
        return $this->getSiteUrl($path, $scheme);
    }

    /**
     * Retrieve the site url for a given site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @since 1.0.0
     * @uses setUrlScheme()
     *
     * @param string $path Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. Currently 'http', 'https', 'login', 'login_post', 'admin', or 'relative'.
     * @return string Site url link with optional path appended.
     */
    public function getSiteUrl($path = '', $scheme = null) {
        $url = Configure::read('General.site_url');

        $url = $this->setUrlScheme($url, $scheme);

        if ($path && is_string($path))
            $url .= '/' . ltrim($path, '/');

        return $this->Hook->applyFilters('site_url', $url, $path, $scheme);
    }

    /**
     * Set the scheme for a URL
     *
     * @since 1.0.0
     *
     * @param string $url Absolute url that includes a scheme
     * @param string $scheme Optional. Scheme to give $url. Currently 'http', 'https', 'login', 'login_post', 'admin', or 'relative'.
     * @return string $url URL with chosen scheme.
     */
    public function setUrlScheme($url, $scheme = null) {
        $orig_scheme = $scheme;
        if (!in_array($scheme, array('http', 'https', 'relative'))) {
            if (( 'login_post' == $scheme || 'rpc' == $scheme ) && ( Functions::force_ssl_login() || Functions::force_ssl_admin() ))
                $scheme = 'https';
            elseif (( 'login' == $scheme ) && Functions::force_ssl_admin())
                $scheme = 'https';
            elseif (( 'admin' == $scheme ) && Functions::force_ssl_admin())
                $scheme = 'https';
            else
                $scheme = ( Functions::is_ssl() ? 'https' : 'http' );
        }

        if ('relative' == $scheme)
            $url = preg_replace('#^.+://[^/]*#', '', $url);
        else
            $url = preg_replace('#^.+://#', $scheme . '://', $url);

        return $this->Hook->applyFilters('set_url_scheme', $url, $scheme, $orig_scheme);
    }

}