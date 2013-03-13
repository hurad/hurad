<?php

App::uses('HrEventManager', 'Event');
App::uses('Folder', 'Utility');

/**
 * HrPlugin
 * 
 * Reaname class from CroogoPlugin to HrPlugin
 * 
 * @author Fahad Ibnay Heylaal <contact@fahad19.com>
 */
class HrPlugin {

    /**
     * PluginActivation class
     *
     * @var object
     */
    protected $_PluginActivation = null;

    /**
     * __construct
     */
    public function __construct() {
        $this->Option = ClassRegistry::init('Option');
    }

    /**
     * AppController setter
     *
     * @return void
     */
    public function setController(AppController $controller) {
        $this->_Controller = $controller;
    }

    public function getPlugins() {
        $plugins = array();
        $this->folder = new Folder;
        $pluginPaths = App::path('plugins');
        foreach ($pluginPaths as $pluginPath) {
            $this->folder->path = $pluginPath;
            if (!file_exists($this->folder->path)) {
                continue;
            }
            $pluginFolders = $this->folder->read();
            foreach ($pluginFolders[0] as $pluginFolder) {
                if (substr($pluginFolder, 0, 1) != '.') {
                    $this->folder->path = $pluginPath . $pluginFolder . DS . 'Config';
                    if (!file_exists($this->folder->path)) {
                        continue;
                    }
                    $pluginFolderContent = $this->folder->read();
                    if (in_array('plugin.json', $pluginFolderContent[1])) {
                        $plugins[$pluginFolder] = $pluginFolder;
                    }
                }
            }
        }
        return $plugins;
    }

    public function getData($alias = null) {
        $pluginPaths = App::path('plugins');
        foreach ($pluginPaths as $pluginPath) {
            $manifestFile = $pluginPath . $alias . DS . 'Config' . DS . 'plugin.json';
            if (file_exists($manifestFile)) {
                $pluginData = json_decode(file_get_contents($manifestFile), true);
                if (!empty($pluginData)) {
                    $pluginData['active'] = $this->isActive($alias);
                    unset($pluginManifest);
                } else {
                    $pluginData = array();
                }
                return $pluginData;
            }
        }
        return false;
    }

    public function isActive($plugin) {
        $configureKeys = array(
            'Plugin.bootstraps',
        );

        $plugin = array(Inflector::underscore($plugin), Inflector::camelize($plugin));

        foreach ($configureKeys as $configureKey) {
            $hooks = explode(',', Configure::read($configureKey));
            foreach ($hooks as $hook) {
                if (in_array($hook, $plugin)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Loads plugin's bootstrap.php file
     *
     * @param string $plugin Plugin name
     * @return void
     */
    public function addBootstrap($plugin) {
        $pluginBootstraps = Configure::read('Plugin.bootstraps');
        if (!$pluginBootstraps) {
            $plugins = array();
        } else {
            $plugins = explode(',', $pluginBootstraps);
            $names = array(Inflector::underscore($plugin), Inflector::camelize($plugin));
            if ($intersect = array_intersect($names, $plugins)) {
                $plugin = current($intersect);
            }
        }

        if (array_search($plugin, $plugins) !== false) {
            $plugins = $pluginBootstraps;
        } else {
            $plugins[] = $plugin;
            $plugins = implode(',', $plugins);
        }
        $this->Option->write('Plugin.bootstraps', $plugins);
    }

    /**
     * Loads plugin's bootstrap.php file
     *
     * @param string $plugin Plugin name
     * @return void
     * @deprecated use addBootstrap($plugin)
     */
    public function addPluginBootstrap($plugin) {
        $this->addBootstrap($plugin);
    }

    /**
     * Plugin name will be removed from Hook.bootstraps
     *
     * @param string $plugin Plugin name
     * @return void
     */
    public function removeBootstrap($plugin) {
        $pluginBootstraps = Configure::read('Plugin.bootstraps');
        if (!$pluginBootstraps) {
            return;
        }

        $plugins = explode(',', $pluginBootstraps);
        $names = array(Inflector::underscore($plugin), Inflector::camelize($plugin));
        if ($intersect = array_intersect($names, $plugins)) {
            $plugin = current($intersect);
            $k = array_search($plugin, $plugins);
            unset($plugins[$k]);
        }

        if (count($plugins) == 0) {
            $plugins = '';
        } else {
            $plugins = implode(',', $plugins);
        }
        $this->Option->write('Plugin.bootstraps', $plugins);
    }

    /**
     * Plugin name will be removed from Hook.bootstraps
     *
     * @param string $plugin Plugin name
     * @return void
     * @deprecated use removeBootstrap()
     */
    public function removePluginBootstrap($plugin) {
        $this->removeBootstrap($plugin);
    }

    /**
     * Get PluginActivation class
     *
     * @param string $plugin
     * @return object
     */
    public function getActivator($plugin = null) {
        $plugin = Inflector::camelize($plugin);
        if (!isset($this->_PluginActivation)) {
            $className = $plugin . 'Activation';
            $configFile = APP . 'Plugin' . DS . $plugin . DS . 'Config' . DS . $className . '.php';
            if (file_exists($configFile) && include $configFile) {
                $this->_PluginActivation = new $className;
            }
        }
        return $this->_PluginActivation;
    }

    /**
     * Activate plugin
     *
     * @param string $plugin Plugin name
     * @return boolean true when successful, false or error message when failed
     */
    public function activate($plugin) {
        if (CakePlugin::loaded($plugin)) {
            return __('Plugin "%s" is already active.', $plugin);
        }
        $pluginActivation = $this->getActivator($plugin);
        if (!isset($pluginActivation) ||
                (isset($pluginActivation) && method_exists($pluginActivation, 'beforeActivation') && $pluginActivation->beforeActivation($this->_Controller))) {
            $pluginData = $this->getData($plugin);
            $dependencies = true;
            if (!empty($pluginData['dependencies']['plugins'])) {
                foreach ($pluginData['dependencies']['plugins'] as $requiredPlugin) {
                    $requiredPlugin = ucfirst($requiredPlugin);
                    if (!CakePlugin::loaded($requiredPlugin)) {
                        $dependencies = false;
                        $missingPlugin = $requiredPlugin;
                        break;
                    }
                }
            }
            if ($dependencies) {
                $this->addBootstrap($plugin);
                if (isset($pluginActivation) && method_exists($pluginActivation, 'onActivation')) {
                    $pluginActivation->onActivation($this->_Controller);
                }
                HrPlugin::load($plugin);
                Cache::delete('EventHandlers', 'setting_write_configuration');
                return true;
            } else {
                return __('Plugin "%s" depends on "%s" plugin.', $plugin, $missingPlugin);
            }
            return __('Plugin "%s" could not be activated. Please, try again.', $plugin);
        }
    }

    /**
     * Deactivate plugin
     *
     * @param string $plugin Plugin name
     * @return boolean true when successful, false or error message when failed
     */
    public function deactivate($plugin) {
        if (!CakePlugin::loaded($plugin)) {
            return __('Plugin "%s" is not active.', $plugin);
        }
        $pluginActivation = $this->getActivator($plugin);
        if (!isset($pluginActivation) ||
                (isset($pluginActivation) && method_exists($pluginActivation, 'beforeDeactivation') && $pluginActivation->beforeDeactivation($this->_Controller))) {
            $this->removeBootstrap($plugin);
            if (isset($pluginActivation) && method_exists($pluginActivation, 'onDeactivation')) {
                $pluginActivation->onDeactivation($this->_Controller);
            }
            HrPlugin::unload($plugin);
            Cache::delete('EventHandlers', 'setting_write_configuration');
            return true;
        } else {
            return __('Plugin could not be deactivated. Please, try again.');
        }
    }

    /**
     * Loads a plugin and optionally loads bootstrapping and routing files.
     *
     * This method is identical to CakePlugin::load() with extra functionality
     * that loads event configuration when Plugin/Config/events.php is present.
     *
     * @see CakePlugin::load()
     * @param mixed $plugin name of plugin, or array of plugin and its config
     * @return void
     */
    public static function load($plugin, $config = array()) {
        CakePlugin::load($plugin, $config);
        if (is_string($plugin)) {
            $plugin = array($plugin => $config);
        }
        foreach ($plugin as $name => $conf) {
            list($name, $conf) = (is_numeric($name)) ? array($conf, $config) : array($name, $conf);
            $file = CakePlugin::path($name) . 'Config' . DS . 'events.php';
            if (file_exists($file)) {
                Configure::load($name . '.events');
            }
        }
    }

    /**
     * Forgets a loaded plugin or all of them if first parameter is null
     *
     * This method is identical to CakePlugin::load() with extra functionality
     * that unregister event listeners when a plugin in unloaded.
     *
     * @see CakePlugin::unload()
     * @param string $plugin name of the plugin to forget
     * @return void
     */
    public static function unload($plugin) {
        $eventManager = HrEventManager::instance();
        if ($eventManager instanceof HrEventManager) {
            if ($plugin == null) {
                $activePlugins = CakePlugin::loaded();
                foreach ($activePlugins as $activePlugin) {
                    $eventManager->detachPluginSubscribers($activePlugin);
                }
            } else {
                $eventManager->detachPluginSubscribers($plugin);
            }
        }
        CakePlugin::unload($plugin);
    }

    /**
     * Delete plugin
     *
     * @param string $plugin Plugin name
     * @return boolean true when successful, false or array of error messages when failed
     */
    public function delete($plugin) {
        $pluginPath = APP . 'Plugin' . DS . $plugin;
        $folder = new Folder();
        $result = $folder->delete($pluginPath);
        if ($result !== true) {
            return $folder->errors();
        }
        return true;
    }

}