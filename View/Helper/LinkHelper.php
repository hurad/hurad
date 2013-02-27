<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of LinkHelper
 *
 * @author mohammad
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
    function the_permalink() {
        echo $this->Hook->apply_filters('the_permalink', $this->get_permalink());
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
    function permalink_anchor($mode = 'id') {
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
    function get_permalink() {
        $year = $this->Time->format('Y', $this->post['Post']['created']);
        $month = $this->Time->format('m', $this->post['Post']['created']);
        $day = $this->Time->format('d', $this->post['Post']['created']);
        if ($this->post['Post']['type'] == 'post') {
            switch (Configure::read('Permalink-common')) {
                case 'default':
                    $permalink = $this->Html->url(Configure::read('General-site_url') . "/p/" . $this->post['Post']['id']);
                    break;
                case 'day_name':
                    $permalink = $this->Html->url(Configure::read('General-site_url') . "/" . $year . "/" . $month . "/" . $day . "/" . $this->post['Post']['slug']);
                    break;
                case 'month_name':
                    $permalink = $this->Html->url(Configure::read('General-site_url') . "/" . $year . "/" . $month . "/" . $this->post['Post']['slug']);
                    break;
                default:
                    break;
            }
        } elseif ($this->post['Post']['type'] == 'page') {
            if (Configure::read('Permalink-common') == 'default') {
                $permalink = $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->post['Post']['id']);
            } else {
                $permalink = $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->post['Post']['slug']);
            }
        }
        return $this->Hook->apply_filters('post_link', $permalink);
    }

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
            $scheme = Functions::is_ssl() && !is_admin() ? 'https' : 'http';
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
            $scheme = ( Functions::is_ssl() ? 'https' : 'http' );
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
