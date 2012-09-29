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

    public function beforeFilter() {

        $this->theme = Configure::read('template');
        //$this->bcheck();
        $this->Auth->allow();

        if (isset($this->params['admin'])) {
            $this->layout = 'admin';
        }

        //Set logged_in var in all view
        $this->set('logged_in', $this->Auth->loggedIn());

        //Set current_user var in all view
        $this->set('current_user', $this->Auth->user());

        //Set url var in all view
        $this->set('url', $this->request->url);

        $this->set('controller', $this->params['controller']);

        //Set user_cookie var in all view
        $this->set('user_cookie', $this->Cookie->read('Hurad_User'));

        $this->set('isadmin', $this->isAdmin());

        //debug(Configure::read('options'));
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

    function bcheck() {
        $cookie = $this->Cookie->read('Hurad_User');

        if (!is_array($cookie) || $this->Auth->user())
            return;

        if ($this->Auth->login($cookie)) {
            $this->Cookie->write('Hurad_User', $cookie, true, '+2 weeks');
        } else {
            $this->Cookie->delete('Hurad_User');
        }
    }

}
