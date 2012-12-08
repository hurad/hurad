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
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Cookie',
        'Session',
        'DebugKit.Toolbar',
        //'Security' => array('csrfUseOnce' => false, 'csrfExpires' => '+1 hour'),
        'Auth' => array(
            //'fields' => array('username' => 'username', 'password' => 'password'),
            'loginAction' => array('admin' => false, 'controller' => 'users', 'action' => 'login'),
            'loginRedirect' => '/admin/',
            'logoutAction' => array('admin' => false, 'controller' => 'users', 'action' => 'logout'),
            'logoutRedirect' => array('admin' => false, 'controller' => 'users', 'action' => 'login'),
            'authorize' => array('Controller')
        )
    );
    public $uses = array('User');

    public function beforeFilter() {
        //Cookie Configuration
        $this->Cookie->name = 'Hurad';
        
        //Set default theme
        $this->theme = Configure::read('template');
        
        $this->cookie_check();

        if (isset($this->request->params['admin'])) {
            $this->layout = 'admin';
        }

        //Set logged_in var in all view
        $this->set('logged_in', $this->Auth->loggedIn());

        //Set current_user var in all view
        $this->set('current_user', $this->Auth->user());

        //Set url var in all view
        $this->set('url', $this->request->url);

        //Set current controller
        $this->set('controller', $this->request->params['controller']);

        //Set user_cookie var in all view
        $this->set('user_cookie', $this->Cookie->read('Hurad_User'));

        $this->set('isadmin', $this->isAdmin());

        //Load Option model in all controller
        $this->options = Configure::read('options');
    }

    private function isAdmin() {
        $admin = FALSE;
        if (!is_null($this->Auth->user()) && $this->Auth->user('role') == 'admin') {
            $admin = TRUE;
        }
        return $admin;
    }

    private function cookie_check() {
        $cookie = $this->Cookie->read('Auth.User');
        if (!is_array($cookie) || $this->Auth->user()) {
            return;
        }
        $user = $this->User->find('first', array(
            'fields' => array('User.username', 'User.password', 'User.role'),
            'conditions' => array(
                'User.username' => $cookie['User']['username'],
                'User.password' => AuthComponent::password($cookie['User']['password'])
            ),
            'recursive' => 0)
        );
        if ($this->Auth->login($user['User'])) {
            $this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
        } else {
            $this->Cookie->delete('Auth.User');       
        }
    }

}
