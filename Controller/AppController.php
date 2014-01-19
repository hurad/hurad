<?php
/**
 * Application level Controller
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property HuradComponent $Hurad
 */
class AppController extends Controller
{
    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     */
    public $components = [
        'Security' => ['csrfUseOnce' => false],
        'Role',
        'Cookie',
        'Session',
        'Auth' => [
            'loginAction' => [
                'plugin' => false,
                'admin' => false,
                'controller' => 'users',
                'action' => 'login'
            ],
            'loginRedirect' => '/admin',
            'logoutAction' => [
                'admin' => false,
                'controller' => 'users',
                'action' => 'logout'
            ],
            'logoutRedirect' => [
                'admin' => false,
                'controller' => 'users',
                'action' => 'login'
            ],
            'authorize' => ['Controller'],
            'flash' => [
                'element' => 'auth',
                'key' => 'auth',
                'params' => []
            ]
        ]
    ];

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        //Cookie Configuration
        $this->Cookie->name = 'Hurad';

        if (!isset($this->params['admin']) && $this->params['action'] != 'login') {
            $this->theme = Configure::read('template');
        }

        if (!Configure::read('Installed')) {
            $this->layout = 'install';
            $this->theme = false;
        } else {
            $this->cookieCheck();
        }

        //Load admin layout
        if (isset($this->request->params['admin'])) {
            $this->layout = 'admin';
        }

        //Set $loggedIn var in all view
        $this->set('loggedIn', $this->Auth->loggedIn());

        if ($this->Auth->loggedIn() && Configure::read('Installed')) {
            //Set current_user var in all view
            $this->set('current_user', (array)ClassRegistry::init('User')->getUser($this->Auth->user('id')));
        }

        //Set url var in all view
        $this->set('url', $this->request->url);

        //Set current controller
        $this->set('controller', $this->request->params['controller']);

        //Set current action
        $this->set('action', $this->request->params['action']);

        //Set user_cookie var in all view
        $this->set('user_cookie', $this->Cookie->read('Hurad_User'));

        $this->set('isAdmin', $this->isAdmin());

        $this->set('isRTL', $this->isRTL());
        $this->set('cssRTL', $this->setRtlCSS());

        //Load Option model in all controller
        //$this->options = Configure::read('options');
        //Use request in model
        $this->{$this->modelClass}->request = $this->request;

        $this->set('themePath', APP . 'View' . DS . 'Themed' . DS . Configure::read('template') . DS);
    }

    /**
     * Called before the all controller action
     *
     * @param array $user Current user
     *
     * @return mixed
     */
    public function isAuthorized($user)
    {
        return $this->Role->checkAuthorization($user);
    }

    /**
     * Check current user
     *
     * @return bool if current user is admin return true else return false
     */
    private function isAdmin()
    {
        $admin = false;
        if (!is_null($this->Auth->user()) && $this->Auth->user('role') == 'administrator') {
            $admin = true;
        }

        return $admin;
    }

    /**
     * Check language is rtl or not
     *
     * @return bool
     */
    protected function isRTL()
    {
        return ('rtl' == Configure::read('Hurad.language.catalog.direction'));
    }

    /**
     * Set admin rtl css
     *
     * @return array
     */
    protected function setRtlCSS()
    {
        $css = [];
        if ('rtl' == Configure::read('Hurad.language.catalog.direction')) {
            $css[] = 'bootstrap.min.rtl.css';
        }

        return $css;
    }

    protected function cookieCheck()
    {
        $cookie = $this->Cookie->read('Auth.User');
        if (!is_array($cookie) || $this->Auth->user()) {
            return;
        }

        $user = ClassRegistry::init('User')->find(
            'first',
            [
                'fields' => ['User.username', 'User.password', 'User.role', 'User.email', 'User.url'],
                'conditions' => [
                    'User.username' => $cookie['User']['username'],
                    'User.password' => Security::hash($cookie['User']['password'], null, true)
                ],
                'recursive' => 0
            ]
        );
        
        if ($this->Auth->login($user['User'])) {
            $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
        } else {
            $this->Cookie->delete('Auth.User');
        }
    }
}
