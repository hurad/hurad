<?php
/**
 * Theme library
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
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Class HuradTheme
 *
 * @todo Complete phpDoc
 */
class HuradTheme
{
    public static function getThemeData()
    {
        $defaults = array(
            'name' => '',
            'description' => '',
            'theme_url' => '',
            'author' => '',
            'author_url' => '',
            'version' => '',
            'tags' => ''
        );

        App::import('Utility', 'Xml');
        $viewPath = App::path('View');
        $dir = new Folder($viewPath[0] . 'Themed');
        $files = $dir->read(true, array('empty'));

        foreach ($files[0] as $i => $folder) {
            $file = new File($viewPath[0] . 'Themed' . DS . $folder . DS . 'Config' . DS . 'info.xml');
            if ($file->exists()) {
                $fileContent = $file->read();
                $theme = Xml::toArray(Xml::build($fileContent));
                $themes[Inflector::camelize($folder)] = Hash::merge($defaults, $theme['theme']);
            }
        }

        return $themes;
    }

    public static function activate($alias)
    {
        if ($alias == '') {
            return false;
        }

        ClassRegistry::init('Option')->write('template', $alias);

        return true;
    }

    public static function delete($alias)
    {
        $viewPath = App::path('View');
        $folder = new Folder($viewPath[0] . 'Themed' . DS . $alias . DS);

        if ($folder->delete()) {
            return true;
        }

        return false;
    }
}
