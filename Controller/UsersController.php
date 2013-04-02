<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $components = array('Cookie', 'Session');
    public $helpers = array('Gravatar', 'Dashboard', 'Js');
    public $uses = array('UserMeta');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        //$this->isAuthorized();
    }

    public function isAuthorized() {
        switch ($this->Auth->user('role')) {
            case 'admin':
                $this->Auth->allow();
                break;
            case 'user':
                $this->Auth->allow('index', 'profile', 'change_password', 'login', 'logout');
            default :
                $this->Auth->allow('login', 'logout', 'view', 'register');
                break;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function admin_dashboard() {
        $this->set('title_for_layout', __('Dashboard'));
        $comments = ClassRegistry::init('Comment')->find('all', array(
            "fields" => "Comment.id, Comment.user_id, Comment.post_id, Comment.author, Comment.author_url, Comment.author_email, Comment.content, Comment.approved, Post.title",
            "conditions" => array('Comment.approved' => array(0, 1)),
            "order" => "Comment.created DESC",
            "limit" => 5));
        $this->set(compact('comments'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Users'));

        $this->paginate = array(
            'contain' => array('UserMeta'),
        );

        $users_paginate = $this->paginate('User');

        foreach ($users_paginate as $key => $user) {
            if (isset($user['UserMeta']) && count($user['UserMeta']) >= 1) {
                $users_paginate[$key]['UserMeta'] = Set::combine($user['UserMeta'], '{n}.meta_key', '{n}.meta_value');
            }
        }

        $this->set('users', $users_paginate);
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->set('title_for_layout', __('Add new user'));
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'error');
            }
        }
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_profile($id = null) {
        $this->set('title_for_layout', __('Profile'));
        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['UserMeta'])) {
                foreach ($this->request->data['UserMeta'] as $meta_key => $meta_value) {
                    //Update user_metas table.
                    $this->UserMeta->updateAll(array('UserMeta.meta_value' => "'$meta_value'"), array('UserMeta.user_id' => $id, 'UserMeta.meta_key' => $meta_key));
                }
            }

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->set('errors', $this->User->validationErrors);
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'error');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);

            //Retraive user_metas table.
            $this->request->data['UserMeta'] = $this->UserMeta->find('list', array(
                'conditions' => array('UserMeta.user_id' => $id),
                'fields' => array('UserMeta.meta_key', 'UserMeta.meta_value'),
                    )
            );
        }
    }

    /**
     * admin_delete method
     *
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'error');
        $this->redirect(array('action' => 'index'));
    }

    /**
     * login method
     *
     * @return void
     */
    public function login() {
        $this->layout = "admin_login";
        if ($this->Auth->loggedIn()) {
            $this->Session->setFlash(__('You already login.'), 'notice');
            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => TRUE));
        } else {
            if ($this->request->is('post')) {
                if (!empty($this->request->data)) {
                    if ($this->Auth->login()) {
                        $this->_setCookie();
                        $this->Session->setFlash(__('%s you have successfully logged in', $this->Auth->user('username')), 'success');
                        $this->redirect($this->Auth->redirect());
                    } else {
                        $this->Session->setFlash(__('Your username or password was incorrect.'), 'error');
                    }
                }
            }
        }
    }

    /**
     * logout method
     *
     * @return void
     */
    public function logout() {
        if ($this->Auth->loggedIn()) {
            //$this->Cookie->delete('Hurad');
            $this->Session->destroy();
            $this->Cookie->destroy();
            $this->Session->setFlash(__('You are successfully logout'), 'flash_notice');
            $this->redirect($this->Auth->logout());
        } else {
            $this->Session->setFlash(__('You already logout.'), 'flash_notice');
            $this->redirect('/');
        }
    }

    /**
     * Sets the cookie to remember the user
     *
     * @param array Cookie component properties as array, like array('domain' => 'yourdomain.com')
     * @param string Cookie data keyname for the userdata, its default is "User". This is set to User and NOT using the model alias to make sure it works with different apps with different user models accross different (sub)domains.
     * @return void
     */
    private function _setCookie($options = array(), $cookieKey = 'Auth.User') {
        if (empty($this->request->data['User']['remember_me'])) {
            $this->Cookie->delete($cookieKey);
        } else {
            $cookie = array();
            $cookie['User']['username'] = $this->request->data['User']['username'];
            $cookie['User']['password'] = $this->request->data['User']['password'];
            $this->Cookie->write($cookieKey, $cookie, TRUE, '+2 weeks');
        }
        unset($this->request->data['User']['remember_me']);
    }

    /**
     * change_password method
     *
     * @return void
     */
    public function change_password() {
        $this->layout = "admin";
        if ($this->request->is('post')) {
            // Set User's ID in model which is needed for validation
            $this->User->id = $this->Auth->user('id');
            if ($this->User->save($this->request->data)) {
                debug($this->request->data);
                //Find user by id
                $user = $this->User->findById($this->Auth->user('id'));

                $email = new CakeEmail('gmail');
                $email->emailFormat('html');
                $email->template('change_password');
                $email->viewVars(array(
                    'new_password' => $this->request->data['User']['password'],
                    'username' => $user['User']['username']
                ));
                $email->from(array('info@cakeblog.com' => 'CakeBlog'));
                $email->to('m.abdolirad@gmail.com');
                $email->subject('Change Password');
                $email->send('You are change password');
                $this->Session->setFlash(__('Your password has been updated'), 'flash_notice');
                $this->redirect(array('admin' => TRUE, 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('Could not be changed password. Please, try again.'), 'flash_notice');
            }
        }
    }

    /**
     * register method
     *
     * @return void
     */
    public function register() {
        $this->layout = "admin_login";
        $this->set('title_for_layout', __('Register'));
        if ($this->request->is('post')) {
            $this->request->data['User']['role'] = Configure::read('General-default_role');
            $this->request->data['User']['activation_key'] = $this->_getActivationKey();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $email = new CakeEmail('gmail');
                $email->emailFormat('html');
                $email->template('register');
                $email->viewVars(array(
                    'password' => $this->request->data['User']['password'],
                    'username' => $this->request->data['User']['username'],
                    'activation_key' => $this->request->data['User']['activation_key'],
                    'siteurl' => Configure::read('General-site_url'),
                    'email' => $this->request->data['User']['email']
                ));
                $email->from(array('info@cakeblog.com' => 'CakeBlog'));
                $email->to('m.abdolirad@gmail.com');
                $email->subject('Register to CakeBlog');
                $email->send('Thank you register Cakeblog');
                $this->Session->setFlash(__('Congratulations, You are Successfully register'), 'flash_notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'flash_error');
            }
        }
    }

    /**
     * profile method
     *
     * @param string $id
     * @return void
     */
    public function profile($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    /**
     * _getActivationKey method
     *
     * @param void
     * @return string activation key
     */
    private function _getActivationKey() {
        return Security::hash(date('Y-m-d H:i:s'), $type = NULL, $salt = TRUE);
    }

    /**
     * verify method
     *
     * @param void
     * @return string activation key
     */
    public function verify($key = NULL) {
        //Find id from users table
        $user = $this->User->find('first', array(
            'conditions' => array('User.activation_key' => $key))
        );
        $this->User->id = $user['User']['id'];
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid Key'));
        }
        if (is_null($key)) {
            return FALSE;
        } else {
            if ($user) {
                if ($this->User->saveField('status', '1')) {
                    $email = new CakeEmail('gmail');
                    $email->emailFormat('html');
                    $email->template('verify');
//                    $email->viewVars(array(
//                        'password' => $this->request->data['User']['password'],
//                        'username' => $this->request->data['User']['username'],
//                        'activation_key' => $this->request->data['User']['activation_key'],
//                        'siteurl' => $option['Option']['value'],
//                        'email' => $this->request->data['User']['email']
//                    ));
                    $email->from(array('info@cakeblog.com' => 'CakeBlog'));
                    $email->to('m.abdolirad@gmail.com');
                    $email->subject('Confirmed your account');
                    $email->send('Thank you confirm Cakeblog');
                    $this->Session->setFlash(__('User confirm.'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('Could not be confirm your email. Please, try again.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash(__('Your activation key not valid.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function forgot() {

        if (!empty($this->request->data) && isset($this->request->data['User']['username'])) {
            $user = $this->User->findByUsername($this->request->data['User']['username']);
            if (!isset($user['User']['id'])) {
                $this->Session->setFlash(__('Invalid username.'));
                $this->redirect(array('action' => 'login'));
            }

            $this->User->id = $user['User']['id'];
            $resetKey = md5(uniqid());
            $this->User->saveField('reset_key', $resetKey);
            //$this->set(compact('user', 'resetKey'));
//            $this->Email->from = Configure::read('Site.title') . ' '
//                    . '<croogo@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])) . '>';
//            $this->Email->to = $user['User']['email'];
//            $this->Email->subject = '[' . Configure::read('Site.title') . '] ' . __('Reset Password');
//            $this->Email->template = 'forgot_password';


            $email = new CakeEmail('gmail');
            $email->emailFormat('html');
            $email->template('forgot_password');
            $email->viewVars(array(
                'reset_key' => $resetKey,
                'username' => $user['User']['username'],
                    //'email' => $this->request->data['User']['email']
            ));
            $email->from(array('info@cakeblog.com' => 'CakeBlog'));
            $email->to($user['User']['email']);
            $email->subject(__('Reset Password'));
            //$email->send('Thank you confirm Cakeblog');



            if ($email->send()) {
                $this->Session->setFlash(__('An email has been sent with instructions for resetting your password.'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('An error occurred. Please try again.'), 'default', array('class' => 'error'));
            }
        }
    }

    public function reset($key = null) {
        //$this->set('title_for_layout', __('Reset Password'));

        if ($key == null) {
            $this->Session->setFlash(__('An error occurred.'));
            $this->redirect(array('action' => 'login'));
        }

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.reset_key' => $key,
            ),
        ));
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__('An error occurred.'));
            $this->redirect(array('action' => 'login'));
        }

        if (!empty($this->request->data) && isset($this->request->data['User']['password'])) {
            $this->User->id = $user['User']['id'];
            $user['User']['password'] = Security::hash($this->request->data['User']['password'], null, true);
            //$user['User']['activation_key'] = md5(uniqid());
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your password has been reset successfully.'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('An error occurred. Please try again.'));
            }
        }

        $this->set(compact('user', 'username', 'key'));
    }

    function check() {
        $cookie = $this->Cookie->read($this->cookieName);

        if (!is_array($cookie) || $this->Auth->user())
            return;

        if ($this->Auth->login($cookie)) {
            $this->Cookie->write($this->cookieName, $cookie, true, $this->period);
        } else {
            $this->Cookie->delete($this->cookieName);
        }
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->request->data['User']['action'];
        $ids = array();
        foreach ($this->request->data['User'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->User->deleteAll(array('User.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Users deleted.'), 'notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}