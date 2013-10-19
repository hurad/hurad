<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Class HuradPlugin
 */
class HuradPlugin
{

    public static function getPluginData()
    {
        $dir = new Folder(APP . DS . 'Plugin');
        $files = $dir->read(true, array('empty'));
        foreach ($files[0] as $i => $folder) {
            $file = new File(APP . 'Plugin' . DS . $folder . DS . 'Config' . DS . 'info.xml');
            if ($file->exists()) {
                $fileContent = $file->read();
                $plugin = Xml::toArray(Xml::build($fileContent));
                $plugins[$folder] = $plugin['plugin'];
            }
        }

        return $plugins;
    }

    public static function isActive($alias = null)
    {
        if (Configure::check('Plugins')) {
            $aliases = Configure::read('Plugins');
            $aliases = explode(',', $aliases);

            return in_array($alias, $aliases);
        } else {
            return false;
        }
    }

    public static function activate($alias)
    {
        $aliases = Configure::read('Plugins');
        if (Configure::check('Plugins') && !empty($aliases)) {
            $aliases = explode(',', $aliases);

            if (count($aliases) > 0) {
                $result = Hash::merge($aliases, $alias);
                $plugins = implode(',', $result);
            } else {
                $plugins = $alias;
            }
        } else {
            $plugins = $alias;
        }
        ClassRegistry::init('Option')->write('Plugins', $plugins);
        return true;
    }

    public static function deactivate($alias)
    {
        if (Configure::check('Plugins')) {
            $aliases = Configure::read('Plugins');
            $aliases = explode(',', $aliases);
            if (count($aliases) > 0) {
                foreach ($aliases as $i => $value) {
                    if ($alias == $value) {
                        $result = Hash::remove($aliases, $i);
                    }
                }
                $plugins = implode(',', $result);
                ClassRegistry::init('Option')->write('Plugins', $plugins);
                return true;
            }
        } else {
            return false;
        }
    }

    public static function delete($alias)
    {
        $folder = new Folder(APP . 'Plugin' . DS . $alias);
        if ($folder->delete()) {
            return true;
        } else {
            return $folder->errors();
        }
    }

    public static function loadAll()
    {
        $plugins = Configure::read('Plugins');

        if (Configure::check('Plugins') && !empty($plugins)) {
            $plugins = explode(',', $plugins);
            $config = array();
            foreach ($plugins as $i => $pluginFolder) {
                $bs = new File(APP . 'Plugin' . DS . $pluginFolder . DS . 'Config' . DS . 'bootstrap.php');
                $rt = new File(APP . 'Plugin' . DS . $pluginFolder . DS . 'Config' . DS . 'routes.php');
                if ($bs->exists()) {
                    $config[$pluginFolder]['bootstrap'] = true;
                }
                if ($rt->exists()) {
                    $config[$pluginFolder]['routes'] = true;
                }
                if ($bs->exists() == false && $rt->exists() == false) {
                    $config[$pluginFolder] = array();
                }
            }
            CakePlugin::load($config);
        }
    }

}