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
        $this->set('title_for_layout', __('First step'));
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
                    if ($this->__executeSQL('hurad.sql', $db)) {
                        $file = new File(CONFIG . 'database.php', true, 0644);

                        if ($file->exists() && $file->writable()) {
                            $default = '$default';
                            $test = '$test';
                            $data = <<<EOF
<?php

class DATABASE_CONFIG {

    public $default = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => '{$config['host']}',
        'login' => '{$config['login']}',
        'password' => '{$config['password']}',
        'database' => '{$config['database']}',
        'prefix' => 'hr_',
    );
    
    public $test = array(
        'datasource' => 'Database/Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'hurad_test',
    );

}
EOF;
                            $file->write($data);
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
        $this->set('title_for_layout', __('Final Step'));
        $config = get_class_vars('DATABASE_CONFIG');

        if ($this->request->is('post')) {
            ConnectionManager::create('install', $config['default']);
            $db = ConnectionManager::getDataSource('install');

            App::uses('CakeTime', 'Utility');
            $created = CakeTime::format('Y-m-d H:i:s', strtotime('now'));
            $modified = CakeTime::format('Y-m-d H:i:s', strtotime('now'));

            $request = new CakeRequest();

            $password = AuthComponent::password($this->request->data['Installer']['password']);

            if ($db->connected) {
                //Insert Uncategorized category
                $db->query("INSERT INTO `hr_categories`(`id`, `parent_id`, `name`, `slug`, `lft`, `rght`, `description`, `post_count`, `path`, `created`, `modified`) VALUES (1,NULL,'Uncategorized','uncategorized',1,2,'Default Description',1,'Uncategorized','$created','$modified')");

                //Insert "Sample Post"
                $db->query("INSERT INTO `hr_posts`(`id`, `parent_id`, `user_id`, `title`, `slug`, `content`, `excerpt`, `status`, `comment_status`, `comment_count`, `type`, `lft`, `rght`, `created`, `modified`) VALUES (1,NULL,1,'Sample Post','sample-post','Sample Post','','publish','open',1,'post',1,2,'$created','$modified')");

                //Insert relation row between category and post
                $db->query("INSERT INTO `hr_categories_posts`(`category_id`, `post_id`) VALUES (1,1)");

                //Insert first comment
                $db->query("INSERT INTO `hr_comments`(`id`, `parent_id`,
                    `post_id`, `user_id`, `author`, `author_email`,
                    `author_url`, `author_ip`, `content`, `approved`, `agent`,
                    `lft`, `rght`, `created`, `modified`)
                    VALUES (1,NULL,1,1,'{$this->request->data['Installer']['username']}',
                    '{$this->request->data['Installer']['email']}','','{$request->clientIp()}',
                        'This comment has been sent for testing, you can delete it',
                        1,'{$request::header('USER_AGENT')}',1,2,'$created','$modified')");

                //Insert Admin user
                $db->query("INSERT INTO `hr_users`(`id`, `username`, `password`, `nicename`, `email`, `url`, `role`, `status`, `created`, `modified`) VALUES (1,'{$this->request->data['Installer']['username']}','$password','','{$this->request->data['Installer']['email']}','','admin',0,'$created','$modified')");
            } else {
                $this->Session->setFlash(__('Not connected to database.'), 'error');
            }
        }
    }

    private function __executeSQL($fileName, $object) {
        if (file_exists(SCHEMA . $fileName)) {
            $sql = file_get_contents(SCHEMA . $fileName);
            $sql = explode(';', $sql);

            foreach ($sql as $statement) {
                if (trim($statement) != '') {
                    $object->query($statement);
                }
            }
            return true;
        }
    }

}