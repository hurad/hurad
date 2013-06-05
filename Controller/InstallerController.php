<?php

App::uses('AppController', 'Controller');
App::uses('ConnectionManager', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class InstallerController extends AppController {

    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();

        if (Configure::read('Installed')) {
            $this->redirect('/');
        }
        $this->Auth->allow();
        $this->layout = 'install';
    }

    public function index() {
        $this->set('title_for_layout', __('Welcome to Hurad installer'));
    }

    public function database() {
        $this->set('title_for_layout', __('Database Configuration'));
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
            $config = array_merge($defaults, $this->request->data['Installer']);

            try {
                ConnectionManager::create('install', $config);
                $db = ConnectionManager::getDataSource('install');

                if ($db->connected) {
                    if ($this->__executeSQL('hurad.sql', $db, array('$[prefix]' => $config['prefix']))) {
                        $file = new File(CONFIG . 'database.php', true, 0644);

                        if ($file->exists() && $file->writable()) {
                            $databaseConfig = <<<EOF
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
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'hurad_test',
    );

}
EOF;
                            $file->write($databaseConfig);
                        }
                        $this->Session->setFlash(__('Database successfuly installed'), 'success');
                        $this->redirect(array('action' => 'finalize'));
                    }
                }
            } catch (MissingConnectionException $exc) {
                $this->Session->setFlash($exc->getMessage(), 'error');
            }
        }
    }

    public function finalize() {
        $this->set('title_for_layout', __('Hurad Configuration'));
        $config = get_class_vars('DATABASE_CONFIG');

        if ($this->request->is('post')) {
            ConnectionManager::create('install', $config['default']);
            $db = ConnectionManager::getDataSource('install');

            $search = array();

            $search['$[prefix]'] = $config['default']['prefix'];

            App::uses('CakeTime', 'Utility');
            $search['$[created]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));
            $search['$[modified]'] = CakeTime::format('Y-m-d H:i:s', strtotime('now'));

            $request = new CakeRequest();
            $search['$[client_ip]'] = $request->clientIp();
            $search['$[user_agent]'] = $request::header('USER_AGENT');

            $search['$[username]'] = $this->request->data['Installer']['username'];
            $search['$[email]'] = $this->request->data['Installer']['email'];
            $search['$[password]'] = AuthComponent::password($this->request->data['Installer']['password']);
            $search['$[title]'] = $this->request->data['Installer']['title'];

            $serverName = env("SERVER_NAME");
            $url = Router::url('/');
            $search['$[site_url]'] = rtrim("http://" . $serverName . $url, '/');

            if ($db->connected) {
                if ($this->__executeSQL("hurad_defaults.sql", $db, $search)) {
                    $this->Session->setFlash(__('Hurad successfully installed.'), 'success');
                    $this->redirect(array('action' => 'welcome'));
                }
            } else {
                $this->Session->setFlash(__('Not connected to database.'), 'error');
            }
        }
    }

    public function welcome() {
        $this->set('title_for_layout', __('Welcome to Hurad'));

        $file = new File(TMP . 'installed', true, 0644);
    }

    private function __executeSQL($fileName, $object, $search = null) {
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

            foreach ($statements as $statement) {
                if (trim($statement) != '') {
                    $object->query($statement);
                }
            }

            return true;
        } else {
            $this->Session->setFlash(__('File "Config/Schema/%s" not exists.', $fileName), 'error');
            return false;
        }
    }

}