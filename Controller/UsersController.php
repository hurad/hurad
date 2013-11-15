<?php
/**
 * Users Controller
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
App::uses('CakeEmail', 'Network/Email');

/**
 * Class UsersController
 *
 * @property User $User
 */
class UsersController extends AppController
{
    /**
     * Other components utilized by CommentsController
     *
     * @var array
     */
    public $components = array('Cookie', 'Session', 'Hurad', 'RequestHandler', 'Paginator');
    /**
     * An array containing the names of helpers this controller uses.
     *
     * @var array
     */
    public $helpers = array('Gravatar', 'Dashboard');
    /**
     * An array containing the class names of models this controller uses.
     *
     * @var array
     */
    public $uses = array('User', 'UserMeta');
    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = array(
        'User' => array(
            'limit' => 25,
            'order' => array(
                'User.username' => 'desc'
            )
        )
    );

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        //For not logged user's
        $this->Auth->allow(array('register', 'login', 'logout', 'forgot'));
    }

    /**
     * Admin dashboard
     */
    public function admin_dashboard()
    {
        $this->set('title_for_layout', __d('hurad', 'Dashboard'));
        $comments = ClassRegistry::init('Comment')->find(
            'all',
            array(
                "fields" => "Comment.id, Comment.user_id, Comment.post_id, Comment.author, Comment.author_url, Comment.author_email, Comment.content, Comment.approved, Post.title",
                "conditions" => array('Comment.approved' => array(0, 1)),
                "order" => "Comment.created DESC",
                "limit" => 5
            )
        );
        $this->set(compact('comments'));
    }

    /**
     * List of users
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Users'));

        $this->paginate = array_merge(
            $this->paginate,
            array(
                'contain' => array('UserMeta'),
            )
        );
        $this->Paginator->settings = $this->paginate;
        //$usersPaginate = $this->paginate('User');
        $usersPaginate = $this->Paginator->paginate('User');

        foreach ($usersPaginate as $key => $user) {
            if (isset($user['UserMeta']) && count($user['UserMeta']) >= 1) {
                $usersPaginate[$key]['UserMeta'] = Set::combine($user['UserMeta'], '{n}.meta_key', '{n}.meta_value');
            }
        }

        $this->set('users', $usersPaginate);
    }

    /**
     * Add user
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add new user'));
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The user has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The user could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * User profile
     *
     * @param null|int $id User ID
     *
     * @throws NotFoundException
     */
    public function admin_profile($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Profile'));

        if (is_null($id)) {
            $id = $this->Auth->user('id');
        }

        $this->User->id = $id;

        if (!$this->User->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid user'));
        }

        if ($this->Auth->user('role') != 'administrator' && $this->Auth->user('id') != $id) {
            $this->Session->setFlash(
                __d('hurad', 'You do not have permission to access this section.'),
                'flash_message',
                array('class' => 'danger')
            );
            $this->redirect('/admin');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['UserMeta'])) {
                foreach ($this->request->data['UserMeta'] as $meta_key => $meta_value) {
                    //Update user_metas table.
                    $this->UserMeta->updateAll(
                        array('UserMeta.meta_value' => "'$meta_value'"),
                        array('UserMeta.user_id' => $id, 'UserMeta.meta_key' => $meta_key)
                    );
                }
            }

            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The user has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect($this->referer());
            } else {
                $this->set('errors', $this->User->validationErrors);
                $this->Session->setFlash(
                    __d('hurad', 'The user could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->User->read(null, $id);

            //Retraive user_metas table.
            $this->request->data['UserMeta'] = $this->UserMeta->find(
                'list',
                array(
                    'conditions' => array('UserMeta.user_id' => $id),
                    'fields' => array('UserMeta.meta_key', 'UserMeta.meta_value'),
                )
            );
        }
    }

    /**
     * Delete user
     *
     * @param null|int $id User ID
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__d('hurad', 'User deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'User was not deleted'), 'flash_message', array('class' => 'danger'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * User login
     */
    public function login()
    {
        $this->layout = "admin_login";
        $this->set('title_for_layout', __d('hurad', 'Login to admin section'));
        if ($this->Auth->loggedIn()) {
            $this->Session->setFlash(__d('hurad', 'You already login.'), 'flash_message', array('class' => 'warning'));
            $this->redirect($this->Auth->redirectUrl('/admin'));
        } else {
            if ($this->request->is('post')) {
                if (!empty($this->request->data)) {
                    if ($this->Auth->login()) {
                        $this->Session->delete('Message.auth');
                        $this->__setCookie();
                        $this->Session->setFlash(
                            __d('hurad', '%s you have successfully logged in', $this->Auth->user('username')),
                            'flash_message',
                            array('class' => 'success')
                        );
                        $this->redirect($this->Auth->redirectUrl($this->Auth->loginRedirect));
                    } else {
                        $this->Session->setFlash(
                            __d('hurad', 'Your username or password was incorrect.'),
                            'flash_message',
                            array('class' => 'danger')
                        );
                    }
                }
            }
        }
    }

    /**
     * Sets the cookie to remember the user
     *
     * @param string $cookieKey
     */
    private function __setCookie($cookieKey = 'Auth.User')
    {
        if (empty($this->request->data['User']['remember_me'])) {
            $this->Cookie->delete($cookieKey);
        } else {
            $cookie = array();
            $cookie['User']['username'] = $this->request->data['User']['username'];
            $cookie['User']['password'] = $this->request->data['User']['password'];
            $this->Cookie->write($cookieKey, $cookie, true, '+2 weeks');
        }
        unset($this->request->data['User']['remember_me']);
    }

    /**
     * User logout
     */
    public function logout()
    {
        if ($this->Auth->loggedIn()) {
            $this->Session->destroy();
            $this->Cookie->destroy();
            $this->Session->setFlash(
                __d('hurad', 'You are successfully logout'),
                'flash_message',
                array('class' => 'success')
            );
            $this->redirect($this->Auth->logout());
        } else {
            $this->Session->setFlash(__d('hurad', 'You already logout.'), 'flash_message', array('class' => 'warning'));
            $this->redirect('/');
        }
    }

    /**
     * Change password
     */
    public function change_password()
    {
        $this->layout = "admin";
        if ($this->request->is('post')) {
            $this->User->id = $this->Auth->user('id');
            if ($this->User->save($this->request->data)) {
                $user = $this->User->findById($this->Auth->user('id'));
                $this->Hurad->sendEmail(
                    $this->request->data['User']['email'],
                    __d('hurad', 'Change Password'),
                    'change_password',
                    __d('hurad', 'You are change password'),
                    array(
                        'new_password' => $this->request->data['User']['password'],
                        'username' => $user['User']['username']
                    )
                );
                $this->Session->setFlash(
                    __d('hurad', 'Your password has been updated'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('admin' => true, 'action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'Could not be changed password. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * User register
     */
    public function register()
    {
        $this->layout = "admin_login";
        $this->set('title_for_layout', __d('hurad', 'Register'));
        if ($this->request->is('post')) {
            $this->request->data['User']['role'] = Configure::read('General.default_role');
            $this->request->data['User']['activation_key'] = $this->_getActivationKey();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Hurad->sendEmail(
                    $this->request->data['User']['email'],
                    __d('hurad', 'Register to %s', Configure::read('General.site_name')),
                    'register',
                    null,
                    array(
                        'password' => $this->request->data['User']['password'],
                        'username' => $this->request->data['User']['username'],
                        'activationKey' => $this->request->data['User']['activation_key'],
                        'siteUrl' => Configure::read('General.site_url'),
                        'email' => $this->request->data['User']['email']
                    )
                );
                $this->Session->setFlash(
                    __d('hurad', 'Congratulations, You are Successfully register'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The user could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * Generate activation key
     *
     * @return string Generated activation hash
     */
    private function _getActivationKey()
    {
        return Security::hash(date('Y-m-d H:i:s'), null, true);
    }

    /**
     * Verify user
     *
     * @param null|string $key Activation hash
     *
     * @return bool
     * @throws NotFoundException
     */
    public function verify($key = null)
    {
        $user = $this->User->find(
            'first',
            array(
                'conditions' => array('User.activation_key' => $key)
            )
        );
        $this->User->id = $user['User']['id'];
        if (!$this->User->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid Key'));
        }
        if (is_null($key)) {
            return false;
        } else {
            if ($user) {
                if ($this->User->saveField('status', '1')) {
                    $this->Hurad->sendEmail(
                        $this->request->data['User']['email'],
                        __d('hurad', 'Confirmed your account'),
                        'verify',
                        __d('hurad', 'Thank you confirm your account')
                    );
                    $this->Session->setFlash(
                        __d('hurad', 'User confirm.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'Could not be confirm your email. Please, try again.'),
                        'flash_message',
                        array('class' => 'danger')
                    );
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'Your activation key not valid.'),
                    'flash_message',
                    array('class' => 'danger')
                );
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * Forgot password
     */
    public function forgot()
    {
        $this->layout = "admin_login";
        if (!empty($this->request->data) && isset($this->request->data['User']['username'])) {
            $user = $this->User->findByUsername($this->request->data['User']['username']);
            if (!isset($user['User']['id'])) {
                $this->Session->setFlash(__d('hurad', 'Invalid username.'));
                $this->redirect(array('action' => 'login'));
            }

            $this->User->id = $user['User']['id'];
            $resetKey = md5(uniqid());
            $this->User->saveField('reset_key', $resetKey);

            $this->Hurad->sendEmail(
                $user['User']['email'],
                __d('hurad', 'Reset Password'),
                'forgot_password',
                null,
                array(
                    'reset_key' => $resetKey,
                    'username' => $user['User']['username']
                )
            );

            $this->Session->setFlash(
                __d('hurad', 'An email has been sent with instructions for resetting your password.'),
                'flash_message',
                array('class' => 'success')
            );
            $this->redirect(array('action' => 'login'));
        }
    }

    /**
     * Reset password
     *
     * @param null|string $key
     */
    public function reset($key = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Reset Password'));

        if ($key == null) {
            $this->Session->setFlash(__d('hurad', 'An error occurred.'), 'flash_message', array('class' => 'danger'));
            $this->redirect(array('action' => 'login'));
        }

        $user = $this->User->find(
            'first',
            array(
                'conditions' => array(
                    'User.reset_key' => $key,
                ),
            )
        );
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__d('hurad', 'An error occurred.'), 'flash_message', array('class' => 'danger'));
            $this->redirect(array('action' => 'login'));
        }

        if (!empty($this->request->data) && isset($this->request->data['User']['password'])) {
            $this->User->id = $user['User']['id'];
            $user['User']['password'] = Security::hash($this->request->data['User']['password'], null, true);
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'Your password has been reset successfully.'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'An error occurred. Please try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }

        $this->set(compact('user', 'username', 'key'));
    }

    public function check()
    {
        $cookie = $this->Cookie->read($this->cookieName);

        if (!is_array($cookie) || $this->Auth->user()) {
            return;
        }

        if ($this->Auth->login($cookie)) {
            $this->Cookie->write($this->cookieName, $cookie, true, $this->period);
        } else {
            $this->Cookie->delete($this->cookieName);
        }
    }

    /**
     * User processes
     */
    public function admin_process()
    {
        $this->autoRender = false;
        $action = $this->request->data['User']['action'];
        $ids = array();
        foreach ($this->request->data['User'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->User->deleteAll(array('User.id' => $ids), true, true)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Users deleted.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            default:
                $this->Session->setFlash(
                    __d('hurad', 'An error occurred.'),
                    'flash_message',
                    array('class' => 'danger')
                );
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}