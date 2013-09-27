<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Description of HuradTheme
 *
 * @author mohammad
 */
class HuradTheme {

    public static function getThemeData() {
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

    public static function activate($alias) {
        if ($alias == '') {
            return FALSE;
        }
        ClassRegistry::init('Option')->write('template', $alias);
        return TRUE;
    }

    public static function delete($alias) {
        $viewPath = App::path('View');
        $folder = new Folder($viewPath[0] . 'Themed' . DS . $alias . DS);

        if ($folder->delete()) {
            return TRUE;
        }
        return FALSE;
    }

}