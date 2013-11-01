<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @property HuradComponent $Hurad
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $components = array(
        'Security' => array('csrfUseOnce' => false),
        'Role',
        'Cookie',
        'Session',
        'Auth' => array(
            //'fields' => array('username' => 'username', 'password' => 'password'),
            'loginAction' => array(
                'admin' => false,
                'controller' => 'users',
                'action' => 'login'
            ),
            'loginRedirect' => '/admin',
            'logoutAction' => array(
                'admin' => false,
                'controller' => 'users',
                'action' => 'logout'
            ),
            'logoutRedirect' => array(
                'admin' => false,
                'controller' => 'users',
                'action' => 'login'
            ),
            'authorize' => array('Controller'),
            'flash' => array(
                'element' => 'auth',
                'key' => 'auth',
                'params' => array()
            )
        )
    );

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
            $this->__cookieCheck();
        }

        //Load admin layout
        if (isset($this->request->params['admin'])) {
            $this->layout = 'admin';
        }

        //Set $loggedIn var in all view
        $this->set('loggedIn', $this->Auth->loggedIn());

        if ($this->Auth->loggedIn() && Configure::read('Installed')) {
            //Set current_user var in all view
            $this->set('current_user', (array)ClassRegistry::init('User')->getUserData($this->Auth->user('id')));
        }

        //Set url var in all view
        $this->set('url', $this->request->url);

        //Set current controller
        $this->set('controller', $this->request->params['controller']);

        //Set current action
        $this->set('action', $this->request->params['action']);

        //Set user_cookie var in all view
        $this->set('user_cookie', $this->Cookie->read('Hurad_User'));

        $this->set('isadmin', $this->isAdmin());

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

    private function __cookieCheck()
    {
        $cookie = $this->Cookie->read('Auth.User');
        if (!is_array($cookie) || $this->Auth->user()) {
            return;
        }
        $user = ClassRegistry::init('User')->find(
            'first',
            array(
                'fields' => array('User.username', 'User.password', 'User.role', 'User.email', 'User.url'),
                'conditions' => array(
                    'User.username' => $cookie['User']['username'],
                    'User.password' => Security::hash($cookie['User']['password'], null, true)
                ),
                'recursive' => 0
            )
        );
        if ($this->Auth->login($user['User'])) {
            $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
        } else {
            $this->Cookie->delete('Auth.User');
        }
    }

}