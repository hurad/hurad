<?php

/**
 * Class HuradNavigation
 */
class HuradNavigation
{

    private static $menus = array();

    public static function addMenu($slug, $title, $url, $capability, $icon = array())
    {
        if (!self::menuExists($slug)) {
            self::$menus[$slug] = array('title' => $title, 'url' => $url, 'icon' => $icon, 'capability' => $capability);
            Configure::write('Hurad.menus', self::$menus);
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
                self::$menus[$parentSlug]['sub_menus'][$slug] = array(
                    'title' => $title,
                    'url' => $url,
                    'capability' => $capability
                );
            }
        }
    }

    private static function subMenuExists($menuSlug, $subMenuSlug)
    {
        if (count(self::$menus) > 0 && isset(self::$menus[$menuSlug]['sub_menus'])) {
            return array_key_exists($subMenuSlug, self::$menus[$menuSlug]['sub_menus']);
        } else {
            return false;
        }
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