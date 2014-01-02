<?php
/**
 * Link helper
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
App::uses('AppHelper', 'View/Helper');

/**
 * Class LinkHelper
 */
class LinkHelper extends AppHelper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html', 'Time', 'Hook'];

    /**
     * Current post or page array
     *
     * @var array
     */
    public $content = [];

    /**
     * Model of content
     *
     * @var null|string
     */
    private static $model = null;

    /**
     * Set model
     *
     * @return null|string
     */
    public static function getModel()
    {
        return self::$model;
    }

    /**
     * Get model
     *
     * @param null|string $model
     */
    public static function setModel($model)
    {
        self::$model = Inflector::singularize($model);
    }

    /**
     * Display the permalink for the current post.
     *
     * @uses  apply_filters() Calls 'the_permalink' filter on the permalink string.
     */
    function thePermalink()
    {
        echo $this->Hook->applyFilters('the_permalink', $this->getPermalink());
    }

    /**
     * Display permalink anchor for current post.
     *
     * The permalink mode title will use the post title for the 'a' element 'id'
     * attribute. The id mode uses 'post-' with the post ID for the 'id' attribute.
     *
     * @param string $mode Permalink mode can be either 'title', 'id', or default, which is 'id'.
     */
    function permalinkAnchor($mode = 'id')
    {
        switch (strtolower($mode)) {
            case 'title':
                $title = HuradSanitize::title(
                        $this->content[self::$model]['title']
                    ) . '-' . $this->content[self::$model]['id'];
                echo $this->Html->link(null, null, array('id' => $title));
                break;
            case 'id':
            default:
                echo $this->Html->link(
                    null,
                    null,
                    array('id' => self::$model . '-' . $this->content[self::$model]['id'])
                );
                break;
        }
    }

    /**
     * Retrieve the url to the admin area for the current site.
     *
     * @uses  getAdminUrl()
     *
     * @param string $path   Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     *
     * @return string Admin url link with optional path appended.
     */
    public function adminUrl($path = '', $scheme = 'admin')
    {
        return $this->getAdminUrl($path, $scheme);
    }

    /**
     * Retrieve the url to the admin area for a given site.
     *
     * @uses  getSiteUrl()
     *
     * @param string $path   Optional path relative to the admin url.
     * @param string $scheme The scheme to use. Default is 'admin', which obeys force_ssl_admin() and is_ssl(). 'http' or 'https' can be passed to force those schemes.
     *
     * @return string Admin url link with optional path appended.
     */
    public function getAdminUrl($path = '', $scheme = 'admin')
    {
        $url = $this->getSiteUrl('admin/', $scheme);

        if ($path && is_string($path)) {
            $url .= ltrim($path, '/');
        }

        return $this->Hook->applyFilters('admin_url', $url, $path);
    }

    /**
     * Retrieve the site url for the current site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @uses  getSiteUrl()
     *
     * @param string $path   Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. See set_url_scheme().
     *
     * @return string Site url link with optional path appended.
     */
    public function siteUrl($path = '', $scheme = null)
    {
        return $this->getSiteUrl($path, $scheme);
    }

    /**
     * Retrieve the site url for a given site.
     *
     * Returns the 'site_url' option with the appropriate protocol, 'https' if
     * is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl() is
     * overridden.
     *
     * @uses  setUrlScheme()
     *
     * @param string $path   Optional. Path relative to the site url.
     * @param string $scheme Optional. Scheme to give the site url context. Currently 'http', 'https', 'login', 'login_post', 'admin', or 'relative'.
     *
     * @return string Site url link with optional path appended.
     */
    public function getSiteUrl($path = '', $scheme = null)
    {
        $url = Configure::read('General.site_url');

        $url = $this->setUrlScheme($url, $scheme);

        if ($path && is_string($path)) {
            $url .= '/' . ltrim($path, '/');
        }

        return $this->Hook->applyFilters('site_url', $url, $path, $scheme);
    }

    /**
     * Set the scheme for a URL
     *
     * @param string $url    Absolute url that includes a scheme
     * @param string $scheme Optional. Scheme to give $url. Currently 'http', 'https', 'login', 'login_post', 'admin', or 'relative'.
     *
     * @return string $url URL with chosen scheme.
     */
    public function setUrlScheme($url, $scheme = null)
    {
        $originalScheme = $scheme;
        if (is_null($scheme)) {
            $scheme = 'http';
        }

        if ('relative' == $scheme) {
            $url = preg_replace('#^.+://[^/]*#', '', $url);
        } else {
            $url = preg_replace('#^.+://#', $scheme . '://', $url);
        }

        return $this->Hook->applyFilters('set_url_scheme', $url, $scheme, $originalScheme);
    }
}
