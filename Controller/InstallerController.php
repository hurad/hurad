<?php
/**
 * Installer Controller
 *
 * PHP 5
 *
 * @link http://hurad.org Hurad Project
 * @copyright Copyright (c) 2012-2013, Hurad (http://hurad.org)
 * @package app.Controller
 * @since Version 0.1.0
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */
App::uses('AppController', 'Controller');
App::uses('ConnectionManager', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Class InstallerController
 */
class InstallerController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * @var array
     */
    public $uses = array();

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        if (Configure::read('Installed')) {
            $this->redirect('/');
        }
        $this->Auth->allow();
        $this->layout = 'install';
    }

    /**
     * Index installer
     */
    public function index()
    {
        $this->set('title_for_layout', __d('hurad', 'Welcome to Hurad installer'));
    }

    /**
     * Database configuration step
     */
    public function database()
    {
        $this->set('title_for_layout', __d('hurad', 'Database Configuration'));
        $defaults = array(
            'datasource' => 'Database/Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'login' => 'root',
            'password' => '',
            'database' => 'hurad',
            'prefix' => 'hr_',
        );

        if (!empty($this->request->data)) {
            $config = Hash::merge($defaults, $this->request->data['Installer']);

            $file = new File(CONFIG . 'database.php', true, 0644);

            $databaseConfig = <<<CONFIG
<?php

class DATABASE_CONFIG {

    public \$default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => '{$config['host']}',
        'login' => '{$config['login']}',
        'password' => '{$config['password']}',
        'database' => '{$config['database']}',
        'prefix' => '{$config['prefix']}',
    );

    public \$test = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => '{$config['host']}',
        'login' => '{$config['login']}',
        'password' => '{$config['password']}',
        'database' => '{$config['database']}_test',
    );

}
CONFIG;

            if ($file->write($databaseConfig)) {
                try {
                    $dataSource = ConnectionManager::create('default', $config);

                    if ($dataSource->connected) {
                        if ($this->__executeSQL('hurad.sql', $dataSource, array('$[prefix]' => $config['prefix']))) {

                            $this->Session->setFlash(
                                __d('hurad', 'Database successfuly installed'),
                                'flash_message',
                                array('class' => 'success')
                            );
                            $this->redirect(array('action' => 'finalize'));
                        }
                    }
                } catch (MissingConnectionException $exc) {
                    $this->Session->setFlash($exc->getMessage(), 'flash_message', array('class' => 'danger'));
                }
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'Hurad not write Config/database.php'),
                    'flash_message',
                    array('class' => 'danger')
                );
                $this->redirect(array('action' => 'database'));
            }
        }
    }

    /**
     * Hurad configuration step
     */
    public function finalize()
    {
        $this->set('title_for_layout', __d('hurad', 'Hurad Configuration'));
        $dataSource = ConnectionManager::getDataSource('default');

        if ($this->request->is('post')) {
            $search = array();

            $search['$[prefix]'] = $dataSource->config['prefix'];

            App::uses('CakeTime', 'Utility');
            $search['$[created]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));
            $search['$[modified]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));

            $request = new CakeRequest();
            $search['$[client_ip]'] = $request->clientIp();
            $search['$[user_agent]'] = $request::header('USER_AGENT');

            $search['$[username]'] = $this->request->data['Installer']['username'];
            $search['$[email]'] = $this->request->data['Installer']['email'];
            $search['$[password]'] = Security::hash($this->request->data['Installer']['password']);
            $search['$[title]'] = $this->request->data['Installer']['title'];

            $serverName = env("SERVER_NAME");
            $url = Router::url('/');
            $search['$[site_url]'] = rtrim("http://" . $serverName . $url, '/');

            if ($dataSource->connected) {
                if ($this->__executeSQL("hurad_defaults.sql", $dataSource, $search)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Hurad successfully installed.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                    $this->redirect(array('action' => 'welcome'));
                }
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'Not connected to database.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * Final step
     *
     * @throws NotFoundException
     */
    public function welcome()
    {
        $this->set('title_for_layout', __d('hurad', 'Welcome to Hurad'));

        $file = new File(TMP . 'installed', true, 0644);
        if (!$file->exists()) {
            throw new NotFoundException(__d('hurad', '/tmp directory not writable.'));
        }
    }

    /**
     * @param $fileName
     * @param $object
     * @param null $search
     *
     * @return bool
     */
    private function __executeSQL($fileName, DboSource $object, $search = null)
    {
        if (file_exists(SCHEMA . $fileName)) {
            $sql = file_get_contents(SCHEMA . $fileName);
            $contents = explode(';', $sql);

            if ($search && count($search) > 0) {
                foreach ($contents as $content) {
                    $statements[] = str_replace(array_keys($search), array_values($search), $content);
                }
            } else {
                $statements = $contents;
            }

            /** @var $statements [] */
            foreach ($statements as $statement) {
                if (trim($statement) != '') {
                    $object->query($statement);
                }
            }

            return true;
        } else {
            $this->Session->setFlash(
                __d('hurad', 'File "Config/Schema/%s" not exists.', $fileName),
                'flash_message',
                array('class' => 'danger')
            );
            return false;
        }
    }

}