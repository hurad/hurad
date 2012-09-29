<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HrTheme
 *
 * @author mohammad
 */
class HrTheme extends Object {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->Option = ClassRegistry::init('Option');
    }

    /**
     * Get theme aliases (folder names)
     *
     * @return array
     */
    public function getThemes($adminTheme = FALSE) {
//        $themes = array(
//            'default' => 'default',
//        );
        $this->folder = new Folder;
        $viewPaths = App::path('views');
        foreach ($viewPaths as $viewPath) {
            $this->folder->path = $viewPath . 'Themed';
            $themeFolders = $this->folder->read();
            foreach ($themeFolders['0'] as $themeFolder) {
                $this->folder->path = $viewPath . 'Themed' . DS . $themeFolder . DS . 'webroot';
                $themeFolderContent = $this->folder->read();
                //debug($themeFolderContent['1']);
                if (in_array('theme.json', $themeFolderContent['1'])) {
                    $theme = $this->getData($themeFolder);
                    $themes[$themeFolder] = $theme['name'];
                    if ($adminTheme) {
                        if ($themeFolder == Configure::read('template')) {
                            unset($themes[Configure::read('template')]);
                        }
                    }
                } else {
                    //return $themes = array();
                }
            }
        }
        return $themes;
    }

    /**
     * Get the content of theme.json file from a theme
     *
     * @param string $alias theme folder name
     * @return array
     */
    public function getData($alias = null) {
        if ($alias == null || $alias == 'default') {
            $manifestFile = WWW_ROOT . 'theme.json';
        } else {
            $viewPaths = App::path('views');
            foreach ($viewPaths as $viewPath) {
                if (file_exists($viewPath . 'Themed' . DS . $alias . DS . 'webroot' . DS . 'theme.json')) {
                    $manifestFile = $viewPath . 'Themed' . DS . $alias . DS . 'webroot' . DS . 'theme.json';
                    continue;
                }
            }
            if (!isset($manifestFile)) {
                $manifestFile = WWW_ROOT . 'theme.json';
            }
        }
        if (isset($manifestFile) && file_exists($manifestFile)) {
            $themeData = json_decode(file_get_contents($manifestFile), true);
            if ($themeData == null) {
                $themeData = array();
            }
        } else {
            $themeData = array();
        }
        return $themeData;
    }

    /**
     * Get the content of theme.json file from a theme
     *
     * @param string $alias theme folder name
     * @return array
     * @deprecated use getData()
     */
    public function getThemeData($alias = null) {
        return $this->getData($alias);
    }

    /**
     * Activate theme $alias
     * @param $alias theme alias
     * @return mixed On success Setting::$data or true, false on failure
     */
    public function activate($alias) {
        if ($alias == null) {
            $alias = '';
        }
        return $this->Option->write('template', $alias);
    }

}

?>
