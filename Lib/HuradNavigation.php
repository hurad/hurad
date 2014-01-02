<?php
/**
 * Navigation library
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

/**
 * Class HuradNavigation
 *
 * @todo Complete phpDoc
 */
class HuradNavigation
{

    private static $menus = array();

    public static function addMenu($slug, $title, $url, $capability, $icon = array())
    {
        if (!self::menuExists($slug)) {
            self::$menus = Hash::insert(
                self::$menus,
                $slug,
                array('title' => $title, 'url' => $url, 'icon' => $icon, 'capability' => $capability)
            );
        }
    }

    private static function menuExists($menuSlug)
    {
        return Hash::check(self::$menus, $menuSlug);
    }

    public static function addSubMenu($parentSlug, $slug, $title, $url, $capability)
    {
        if (self::menuExists($parentSlug)) {
            if (!self::subMenuExists($parentSlug, $slug)) {
                self::$menus = Hash::insert(
                    self::$menus,
                    $parentSlug . '.sub_menus.' . $slug,
                    array(
                        'title' => $title,
                        'url' => $url,
                        'capability' => $capability
                    )
                );
            }
        }
    }

    /**
     * Get all menus
     *
     * @return array
     */
    public static function getMenus()
    {
        return self::$menus;
    }

    private static function subMenuExists($menuSlug, $subMenuSlug)
    {
        return Hash::check(self::$menus, $menuSlug . '.sub_menus.' . $subMenuSlug);
    }

    public static function addDashboardMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('dashboard', $slug, $title, $url, $capability);
    }

    public static function addPostsMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('posts', $slug, $title, $url, $capability);
    }

    public static function addLinksMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('links', $slug, $title, $url, $capability);
    }

    public static function addPagesMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('pages', $slug, $title, $url, $capability);
    }

    public static function addCommentsMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('comments', $slug, $title, $url, $capability);
    }

    public static function addAppearanceMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('appearance', $slug, $title, $url, $capability);
    }

    public static function addPluginsMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('plugins', $slug, $title, $url, $capability);
    }

    public static function addUsersMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('users', $slug, $title, $url, $capability);
    }

    public static function addOptionsMenu($slug, $title, $url, $capability)
    {
        self::addSubMenu('options', $slug, $title, $url, $capability);
    }

}