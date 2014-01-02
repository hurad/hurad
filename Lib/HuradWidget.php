<?php
/**
 * Widget library
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
 * Class HuradWidget
 *
 * @todo Complete phpDoc
 */
class HuradWidget
{

    public static $sidebars = array();
    public static $widgets = array();

    public static function registerSidebar($args = array())
    {
        $i = count(self::$sidebars) + 1;

        $defaults = array(
            'id' => "sidebar-$i",
            'name' => __d('hurad', 'Sidebar %d', $i),
            'description' => __d('hurad', 'Default description for this sidebar'),
            'class' => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="widgettitle">',
            'after_title' => '</h4>'
        );

        $sidebar = Hash::merge($defaults, $args);

        self::$sidebars[$sidebar['id']] = $sidebar;

        Configure::write('sidebars', self::$sidebars);
    }

    public static function registerWidget($args = array())
    {
        $i = count(self::$widgets) + 1;

        if (!isset($args['id'])) {
            $args['id'] = "widget-" . strtolower(Inflector::slug($args['title']));
        }

        $defaults = array(
            'id' => "widget-$i",
            'title' => __d('hurad', 'Widget %d', $i),
            'description' => __d('hurad', 'Default description for this widget'),
            'element' => '',
        );

        $widget = Hash::merge($defaults, $args);

        self::$widgets[$widget['id']] = $widget;

        Configure::write('widgets', self::$widgets);
    }

    public static function maxNumber($widgetID = null)
    {
        $optionName = Configure::read('template') . '.widgets';
        $sidebarsWidgets = unserialize(Configure::read($optionName));

        if ($sidebarsWidgets) {
            $idArray = Hash::extract($sidebarsWidgets, '{s}.{s}.widget-id');
            $numArray = Hash::extract($sidebarsWidgets, '{s}.{s}.number');

            for ($index = 0; $index < count($idArray); $index++) {
                $newArray[][$idArray[$index]] = $numArray[$index];
            }

            if (count(Hash::extract($newArray, '{n}.' . $widgetID)) == 0) {
                return 1;
            } else {
                return max(Hash::extract($newArray, '{n}.' . $widgetID)) + 1;
            }
        } else {
            return 1;
        }
    }

    public static function getWidgetData($uniqueId)
    {
        $optionName = Configure::read('template') . '.widgets';
        $sidebarsWidgets = unserialize(Configure::read($optionName));

        $getAllData = Hash::extract($sidebarsWidgets, '{s}.' . $uniqueId);

        return array_slice($getAllData[0], 0, (count($getAllData[0]) - 3));
    }

}