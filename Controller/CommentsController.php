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
    public $components = array('RequestHandler');
    public $paginate = array(
        'conditions' => array(
            'Comment.approved' => array(0, 1),
        ),
        'limit' => 15,
        'order' => array(
            'Comment.created' => 'desc'
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'add', 'reply');
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
     * admin_index method
     *
     * @return void
     */
    public function admin_index($action = null) {
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

        switch ($action) {
            case 'moderated':
                $this->set('title_for_layout', __('Moderated comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 0,
                );
                break;

            case 'approved':
                $this->set('title_for_layout', __('Approved comments'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 1,
                );
                break;

            case 'spam':
                $this->set('title_for_layout', __('Spams'));
                $this->paginate['conditions'] = array(
                    'Comment.approved' => 'spam',
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __('Trashes'));
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

        $countComments['all'] = $this->Comment->countComments();
        $countComments['moderated'] = $this->Comment->countComments('moderated');
        $countComments['approved'] = $this->Comment->countComments('approved');
        $countComments['spam'] = $this->Comment->countComments('spam');
        $countComments['trash'] = $this->Comment->countComments('trash');

        $this->set('countComments', $countComments);
        $this->set('comments', $this->paginate());
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
            $this->Session->setFlash(__('Comment was deleted'));
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
                $this->Session->setFlash(__('The post is invalid.'));
                $this->redirect($this->referer());
            } elseif (is_null($comment_id) && !is_int($comment_id)) {
                $this->Session->setFlash(__('The comment is invalid.'));
                $this->redirect($this->referer());
            } else {
                $this->request->data['Comment']['parent_id'] = $comment_id;
                $this->request->data['Comment']['post_id'] = $post_id;
            }

            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__('The reply of comment has been saved.'));
                $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
                $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            }
        }
        $urls = $this->request['pass'];
        $this->set(compact('urls'));
    }

    public function admin_action($action = null, $id = null) {
        $this->autoRender = FALSE;
        $this->Comment->id = $id;
        if (is_null($action)) {
            return FALSE;
        } elseif (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        switch ($action) {
            case 'approved':
                $data = array('id' => $id, 'approved' => '1');
                $msg = __('Comments are approved.');
                $err = __('Comments are not approved, please try again.');
                break;
            case 'disapproved':
                $data = array('id' => $id, 'approved' => '0');
                $msg = __('Comment are unapproved.');
                $err = __('Comment are not unapproved, please try again.');
                break;
            case 'spam':
                $data = array('id' => $id, 'approved' => 'spam');
                $msg = __('Comment marked as spam.');
                $err = __('Comment didn\'t mark as spam, please try again.');
                break;
            case 'trash':
                $data = array('id' => $id, 'approved' => 'trash');
                $msg = __('Comment moved to trash.');
                $err = __('Comment didn\'t move to trash, please try again.');
                break;
            default:
                $this->Session->setFlash(__('An error occurred.'), 'error');
                break;
        }

        if ($this->RequestHandler->isAjax()) {
            $this->Comment->save($data);
        } else {
            if ($this->Comment->save($data)) {
                $this->Session->setFlash($msg, 'notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash($err, 'error');
                $this->redirect(array('action' => 'index'));
            }
        }
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
            $this->Session->setFlash(__('No item selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__('No action selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'approve':
                if ($this->Comment->updateAll(array('Comment.approved' => '1'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments are approved'), 'flash_notice');
                }
                break;

            case 'disapprove':
                if ($this->Comment->updateAll(array('Comment.approved' => '0'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments are unapproved'), 'flash_notice');
                }
                break;

            case 'spam':
                if ($this->Comment->updateAll(array('Comment.approved' => '"spam"'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments marked as spam.'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Comment->updateAll(array('Comment.approved' => '"trash"'), array('Comment.id' => $ids))) {
                    $this->Session->setFlash(__('Comments moved to trash.'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
