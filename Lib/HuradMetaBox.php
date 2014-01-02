<?php
/**
 * Meta box library
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
 * Class HuradMetaBox
 */
class HuradMetaBox
{
    protected static $metaBoxes = [];
    protected static $pluginName = null;

    /**
     * Add meta box
     *
     * @param string $metaId   Meta id
     * @param string $title    Meta box title
     * @param string $element  Element name
     * @param string $position Meta box position
     */
    public static function addMetaBox($metaId, $title, $element, $position)
    {
        self::setPluginName(debug_backtrace());

        self::$metaBoxes[strtolower(self::$pluginName) . "_{$metaId}"] = [
            'title' => $title,
            'element' => $element,
            'plugin' => self::$pluginName,
            'position' => $position
        ];
    }

    /**
     * Get meta boxes
     *
     * @return array
     */
    public static function getMetaBoxes()
    {
        return self::$metaBoxes;
    }

    /**
     * Set plugin name
     *
     * @param array $backtrace Output "debug_backtrace" function
     *
     * @throws CakeException
     */
    protected static function setPluginName(array $backtrace)
    {
        $pluginPath = APP . 'Plugin';

        if (!is_readable($pluginPath)) {
            throw new CakeException(__d('hurad', 'Plugin path is not readable'));
        }

        if (strpos($backtrace[0]['file'], $pluginPath) != 0) {
            throw new CakeException(__d('hurad', 'You should use meta box in plugin'));
        }

        $diffPath = Hash::diff(
            explode(DIRECTORY_SEPARATOR, $backtrace[0]['file']),
            explode(DIRECTORY_SEPARATOR, $pluginPath)
        );

        self::$pluginName = reset($diffPath);
    }
}
