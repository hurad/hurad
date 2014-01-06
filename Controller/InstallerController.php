<?php
/**
 * Installer Controller
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
App::uses('AppController', 'Controller');
App::uses('ConnectionManager', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Class InstallerController
 *
 * @property Installer $Installer
 */
class InstallerController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * Example: `public $uses = array('Product', 'Post', 'Comment');`
     *
     * Can be set to several values to express different options:
     *
     * - `true` Use the default inflected model name.
     * - `array()` Use only models defined in the parent class.
     * - `false` Use no models at all, do not merge with parent class either.
     * - `array('Post', 'Comment')` Use only the Post and Comment models. Models
     *   Will also be merged with the parent class.
     *
     * The default value is `true`.
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $uses = [];

    protected $dbConfigFileContent = null;

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
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

        if ($this->request->is('post')) {
            $this->Installer->set($this->request->data);

            if ($this->Installer->validates()) {
                if (!$this->isValidConnection(
                        'validation_test',
                        $this->request->data['Installer']
                    ) && !array_key_exists('content', $this->request->data['Installer'])
                ) {
                    $this->Session->setFlash(
                        __d('hurad', 'Database connection "Mysql" is missing, or could not be created.'),
                        'flash_message',
                        ['class' => 'danger']
                    );
                    $this->redirect(['action' => 'database']);
                }

                $file = new File(CONFIG . 'database.php', true, 0644);
                $databaseConfig = $this->getDatabaseConfig($this->request->data['Installer']);

                if (!$file->exists()) {
                    $this->Session->setFlash(
                        __d(
                            'hurad',
                            'Hurad can not create <b>"Config/database.php"</b>. <br> Please create <b>"Config/database.php"</b> and insert the following content in it.'
                        ),
                        'flash_message',
                        ['class' => 'danger']
                    );
                    $this->Session->write('contentFile', $databaseConfig);
                    $this->Session->write('databaseConfig', $this->request->data['Installer']);
                    $this->redirect(['action' => 'config']);
                } else {
                    if (!$file->writable() && !array_key_exists('content', $this->request->data['Installer'])) {
                        $this->Session->setFlash(
                            __d(
                                'hurad',
                                'Hurad can not insert database config in <b>"Config/database.php"</b>. <br> Please insert the following content in <b>"Config/database.php"</b>.'
                            ),
                            'flash_message',
                            ['class' => 'danger']
                        );
                        $this->Session->write('contentFile', $databaseConfig);
                        $this->Session->write('databaseConfig', $this->request->data['Installer']);
                        $this->redirect(['action' => 'config']);
                    } else {
                        $file->write($databaseConfig);

                        try {
                            $dataSource = ConnectionManager::getDataSource('default');

                            if ($dataSource->connected) {
                                if ($this->__executeSQL(
                                    'hurad.sql',
                                    $dataSource,
                                    ['$[prefix]' => $this->request->data['Installer']['prefix']]
                                )
                                ) {

                                    $this->Session->setFlash(
                                        __d('hurad', 'Database successfully installed'),
                                        'flash_message',
                                        ['class' => 'success']
                                    );
                                    $this->redirect(['action' => 'finalize']);
                                }
                            }
                        } catch (Exception $exc) {
                            $this->Session->setFlash($exc->getMessage(), 'flash_message', ['class' => 'danger']);
                        }
                    }
                }
            }
        }
    }

    public function config()
    {
        $this->set('title_for_layout', __d('hurad', 'Save database Configuration'));

        if (!strpos($this->request->referer(), 'installer/database') && !$this->request->is('post')) {
            $this->redirect(['action' => 'database']);
        } else {
            if ($contentFile = $this->Session->read('contentFile')) {
                $this->set(compact('contentFile'));
            }
        }

        if ($this->request->is('post')) {
            try {
                $dataSource = ConnectionManager::getDataSource('default');

                if ($dataSource->connected) {
                    if ($this->__executeSQL(
                        'hurad.sql',
                        $dataSource,
                        ['$[prefix]' => $this->Session->read('databaseConfig')['prefix']]
                    )
                    ) {
                        $this->Session->setFlash(
                            __d('hurad', 'Database successfully installed'),
                            'flash_message',
                            ['class' => 'success']
                        );
                        $this->redirect(['action' => 'finalize']);
                    }
                }
            } catch (Exception $exc) {
                $this->Session->setFlash($exc->getMessage(), 'flash_message', ['class' => 'danger']);
                $this->redirect(['action' => 'database']);
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
            $this->Installer->set($this->request->data);

            if ($this->Installer->validates()) {
                $search = [];

                $search['$[prefix]'] = $dataSource->config['prefix'];

                App::uses('CakeTime', 'Utility');
                $search['$[created]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));
                $search['$[modified]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));

                $request = new CakeRequest();
                $search['$[client_ip]'] = $request->clientIp();
                $search['$[user_agent]'] = $request::header('USER_AGENT');

                $search['$[username]'] = $this->request->data['Installer']['site_username'];
                $search['$[email]'] = $this->request->data['Installer']['email'];
                $search['$[password]'] = Security::hash($this->request->data['Installer']['site_password'], null, true);
                $search['$[title]'] = $this->request->data['Installer']['site_title'];

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
     * @param      $fileName
     * @param      $object
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

    /**
     * Default database config
     *
     * @param array $config
     *
     * @return string
     */
    protected function getDatabaseConfig(array $config)
    {
        $databaseConfig = <<<CONFIG
<?php
/**
 * In this file you set up your database connection details.
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
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 */
class DATABASE_CONFIG {

    public \$default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => '{$config['host']}',
        'login' => '{$config['login']}',
        'password' => '{$config['password']}',
        'database' => '{$config['database']}',
        'prefix' => '{$config['prefix']}',
        'encoding' => 'utf8'
    );

    public \$test = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => '{$config['host']}',
        'login' => '{$config['login']}',
        'password' => '{$config['password']}',
        'database' => '{$config['database']}_test',
        'prefix' => '{$config['prefix']}',
        'encoding' => 'utf8'
    );
}

CONFIG;

        return $databaseConfig;
    }

    protected function isValidConnection($name = '', array $config = [])
    {
        $default = [
            'datasource' => 'Database/Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'login' => 'user',
            'password' => 'password',
            'database' => 'database_name',
            'prefix' => '',
            'encoding' => 'utf8',
        ];

        $config = Hash::merge($default, $config);

        try {
            ConnectionManager::create($name, $config);
            ConnectionManager::getDataSource($name);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}