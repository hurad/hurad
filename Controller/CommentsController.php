<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 */
class CommentsController extends AppController {

    public $helpers = array('AdminLayout', 'Gravatar', 'Js' => array('Jquery'));
    public $components = array('RequestHandler', 'Akismet');
    public $paginate = array(
        'limit' => 15,
        'order' => array(
            'Comment.created' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('*');
        //$this->isAuthorized();
    }

    public function isAuthorized() {
        switch ($this->Auth->user('role')) {
            case 'admin':
                $this->Auth->allow('*');
                break;
            case 'user':
                $this->Auth->allow('*');
            default :
                $this->Auth->allow('*');
                break;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Comment->recursive = 0;
        $this->set('comments', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $this->set('comment', $this->Comment->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Comment->create();
            $this->request->data['Comment']['author_ip'] = CakeRequest::clientIp();
            $this->request->data['Comment']['agent'] = env('HTTP_USER_AGENT');
            $this->request->data['Comment']['approved'] = 0;

            $format = new Formatting();
            $this->request->data['Comment']['author_url'] = $format->esc_url($this->request->data['Comment']['author_url']);
            if ($this->Comment->save($this->request->data)) {
                $this->redirect($this->referer());
//                $email = new CakeEmail('gmail');
//                $email->emailFormat('html');
//                $email->template('add_comment');
//                $email->from(array('info@hurad.org' => 'Hurad'));
//                $email->to($this->request->data['Comment']['author_email']);
//                $email->subject('Comment Submit');
//                $email->send('Your comment submit in blog waiting to approve by admin.');
//                $this->Session->setFlash(__('The comment has been saved'));
//                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The comment has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Comment->read(null, $id);
        }
        $parentComments = $this->Comment->ParentComment->find('list');
        $posts = $this->Comment->Post->find('list');
        $users = $this->Comment->User->find('list');
        $this->set(compact('parentComments', 'posts', 'users'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        if ($this->Comment->delete()) {
            $this->Session->setFlash(__('Comment deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Comment was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Comments'));
        $this->Comment->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->paginate['Comment']['limit'] = 25;
            $this->paginate['Comment']['order'] = array('Comment.created' => 'desc');
            $this->paginate['Comment']['conditions'] = array(
                'Comment.approved' => array(0, 1),
                'Comment.content LIKE' => '%' . $q . '%',
            );
        }
        $this->set('comments', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $this->set('comment', $this->Comment->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The comment has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        }
        $parentComments = $this->Comment->ParentComment->find('list');
        $posts = $this->Comment->Post->find('list');
        $users = $this->Comment->User->find('list');
        $this->set(compact('parentComments', 'posts', 'users'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The comment has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Comment->read(null, $id);
        }
        $parentComments = $this->Comment->ParentComment->find('list');
        $posts = $this->Comment->Post->find('list');
        $users = $this->Comment->User->find('list');
        $this->set(compact('parentComments', 'posts', 'users'));
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
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        if ($this->Comment->delete()) {
            $this->Session->setFlash(__('Comment deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Comment was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * reply method
     * 
     * @param string $post_id
     * @param string $comment_id
     *
     * @return void
     */
    public function reply($post_id = NULL, $comment_id = NULL) {
        if ($this->request->is('post')) {
            $this->Comment->create();

            if (is_null($post_id) && !is_int($post_id)) {
                $this->Session->setFlash(__('The post is not valid'));
                $this->redirect($this->referer());
            } elseif (is_null($comment_id) && !is_int($comment_id)) {
                $this->Session->setFlash(__('The comment is not valid'));
                $this->redirect($this->referer());
            } else {
                $this->request->data['Comment']['parent_id'] = $comment_id;
                $this->request->data['Comment']['post_id'] = $post_id;
            }

            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The reply comment has been saved'));
                $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
                $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            }
        }
        $urls = $this->request['pass'];
        $this->set(compact('urls'));
    }

    /**
     * approve method
     *
     * @param string $id
     * @return void
     */
    public function admin_approve($id = null) {
        if ($this->RequestHandler->isAjax()) {
            $this->autoRender = FALSE;
            $this->Comment->id = $id;
            if (!$this->Comment->exists()) {
                throw new NotFoundException(__('Invalid comment'));
            }
            $data = array('id' => $id, 'approved' => '1');

            if ($this->Comment->save($data)) {
                //$this->Session->setFlash(__('Comment approved.'), 'notice');
                //$this->redirect(array('action' => 'index'));
            } else {
//                $this->Session->setFlash(__('Comment not approved please try again.'), 'error');
//                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Comment->id = $id;
            if (!$this->Comment->exists()) {
                throw new NotFoundException(__('Invalid comment'));
            }
            $data = array('id' => $id, 'approved' => '1');

            if ($this->Comment->save($data)) {
                $this->Session->setFlash(__('Comment approved.'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Comment not approved please try again.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * disapprove method
     *
     * @param string $id
     * @return void
     */
    public function admin_disapprove($id = null) {
        if ($this->RequestHandler->isAjax()) {
            $this->autoRender = FALSE;
            $this->Comment->id = $id;
            if (!$this->Comment->exists()) {
                throw new NotFoundException(__('Invalid comment'));
            }
            $data = array('id' => $id, 'approved' => '0');

            if ($this->Comment->save($data)) {
                //
            } else {
                //
            }
        } else {
            $this->Comment->id = $id;
            if (!$this->Comment->exists()) {
                throw new NotFoundException(__('Invalid comment'));
            }
            $data = array('id' => $id, 'approved' => '0');

            if ($this->Comment->save($data)) {
                $this->Session->setFlash(__('Comment disapproved.'), 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Comment not disapproved please try again.'), 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * admin_filter method
     *
     * @param string $action
     * @return void
     */
    public function admin_filter($action = null) {
        $this->Comment->recursive = 0;
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'moderated':
                $this->set('title_for_layout', __('Comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 0,
                );
                break;

            case 'approved':
                $this->set('title_for_layout', __('Comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 1,
                );
                break;

            case 'spam':
                $this->set('title_for_layout', __('Comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 'spam',
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __('Comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 'trash',
                );
                break;

            default:
                $this->set('title_for_layout', __('Comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => array(0, 1),
                );
                break;
        }

        $this->paginate['order'] = array('Comment.created' => 'desc');
        $this->set('comments', $this->paginate('Comment'));
        $this->render('admin_index');
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->request->data['Comment']['action'];
        $ids = array();
        foreach ($this->request->data['Comment'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__('No items selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'approve':
                if ($this->Comment->updateAll(array('Comment.approved' => '1'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments approved'), 'flash_notice');
                }
                break;

            case 'disapprove':
                if ($this->Comment->updateAll(array('Comment.approved' => '0'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments unapproved'), 'flash_notice');
                }
                break;

            case 'spam':
                if ($this->Comment->updateAll(array('Comment.approved' => '"spam"'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments marked as spam.'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Comment->updateAll(array('Comment.approved' => '"trash"'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments move to trash.'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
