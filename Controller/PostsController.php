<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {

    public $helpers = array('Post', 'Comment', 'Text');
    public $components = array('RequestHandler');
    public $paginate = array(
        'conditions' => array(
            'Post.status' => array('publish', 'draft'),
            'Post.type' => 'post'
        ),
        'limit' => 25,
        'order' => array(
            'Post.created' => 'desc'
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
                $this->Auth->allow();
                break;
            case 'editor':
                $this->Auth->allow('admin_index', 'admin_add', 'admin_edit', 'index', 'view');
                break;
            case 'user':
                $this->Auth->allow('index', 'view');
                break;
            default :
                $this->Auth->allow('index', 'view');
                break;
        }
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        if ($this->RequestHandler->isRss()) {
            $posts = $this->Post->find('all', array('limit' => 20, 'order' => 'Post.created DESC'));
            return $this->set(compact('posts'));
        } else {
            //$this->Post->recursive = 0;
            $this->paginate = array(
                'conditions' => array('Post.type' => 'post'),
                'contain' => array('Category', 'User', 'Tag', 'Comment'),
                'order' => array(
                    'Post.created' => 'desc'
                )
            );
            $this->set('posts', $this->paginate('Post'));
        }
    }

    public function pageIndex() {
        //$pages = $this->Post->generateTreeList(array('type' => 'page'));
        //debug($this->request->named['sort']);
        $pages = $this->Post->find('threaded', array(
            'conditions' => array('Post.type' => 'page'),
            'order' => array('Post.' . $this->request->named['sort'] => $this->request->named['direction']),
                //'limit' => $this->request->named['limit'],
                )
        );

        if (!empty($this->request->params['requested'])) {
//            foreach ($listpage as $id => $slug) {
//                $pages[$id]['path'] = $slug;
//                //$i++;
//            }
            //debug($pages);
            return $pages;
        } else {
            $this->set(compact($pages));
        }
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($slug = null) {
        $this->Post->slug = $slug;
//        if (!$this->Post->exists()) {
//            throw new NotFoundException(__('Invalid post'));
//        }
//        $this->set('post', $this->Post->read(null, $id));
        if (is_null($slug) && !$this->Post->exists()) {
//            $this->Session->setFlash(__('Your post not exist.'));
//            $this->redirect(array('action' => 'index'));
            throw new NotFoundException(__('Invalid post'));
        } else {
            $this->set('post', $this->Post->findBySlug($slug));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->set('title_for_layout', __('Posts'));
        $this->Post->recursive = 0;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->paginate['Post']['limit'] = 25;
            $this->paginate['Post']['order'] = array('Post.created' => 'desc');
            $this->paginate['Post']['conditions'] = array(
                'Post.status' => array('publish', 'draft'),
                'Post.type' => 'post',
                'Post.title LIKE' => '%' . $q . '%',
            );
        }
        $this->set('posts', $this->paginate('Post'));
    }

    /**
     * admin_view method
     *
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $this->Post->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($type = 'post') {
        $this->set('title_for_layout', __('Add Post'));

        if ($this->request->is('post')) {
            // get the tags from the text data
            if ($this->request->data['Post']['tags']) {
                //$this->request->data['Post']['id'] = $id;
                //add code
                $this->_saveTags();
            }

            $this->request->data['Post']['type'] = 'post';
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            // prevent the current tags from being deleted
            $this->Post->hasAndBelongsToMany['Tag']['unique'] = false;
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('The post has been saved'), 'flash_notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The post could not be saved. Please, try again.'), 'flash_error');
            }
        }
        $categories = $this->Post->Category->generateTreeList(null, null, null, '_');
        $this->set(compact('categories'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->set('title_for_layout', __('Edit Post'));
        if (!empty($this->request->data)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                if (empty($this->request->data['Post']['tags'])) {
                    $this->loadModel('PostsTag');
                    $this->PostsTag->deleteAll(array('post_id' => $id), false);
                }
            }

            // get the tags from the textarea data
            $tags = explode(',', $this->request->data['Post']['tags']);
            foreach ($tags as $_tag) {
                $_tag = strtolower(trim($_tag));
                if ($_tag) {
                    $this->Post->Tag->recursive = -1;
                    $tag = $this->Post->Tag->findByName($_tag);
                    if (!$tag) {
                        $this->Post->Tag->create();
                        $tag = $this->Post->Tag->save(array('name' => $_tag, 'slug' => $_tag));
                        $tag['Tag']['id'] = $this->Post->Tag->id;
                        if (!$tag) {
                            $this->Session->setFlash(__(sprintf('The Tag %s could not be saved.', $_tag)), 'flash_error');
                        }
                    }
                    if ($tag) {
                        $this->request->data['Tag']['Tag'][$tag['Tag']['id']] = $tag['Tag']['id'];
                    }
                }
            }

            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            // save the data
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('The Post has been saved.'), 'flash_notice');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Post could not be saved. Please, try again.'), 'flash_error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Post->read(null, $id);
            // load the habtm data for the textarea
            $tags = array();
            if (isset($this->request->data['Tag']) && !empty($this->request->data['Tag'])) {
                foreach ($this->request->data['Tag'] as $tag) {
                    $tags[] = $tag['name'];
                }
                $this->request->data['Post']['tags'] = implode(', ', $tags);
            }
        }

        // get the posts current tags
        $post = $id ? $this->Post->find('all', array('Post.id' => $id)) : false;
        $categories = $this->Post->Category->generateTreeList();
        $this->set(compact('post', 'categories'));
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
        $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException(__('Invalid post'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Post->delete()) {
            $this->Session->setFlash(__('Post deleted'), 'flash_notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Post was not deleted'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    private function _saveTags() {
        // get the tags from the text data
        //$this->request->data['Post']['id'] = $id;
        $tags = explode(',', $this->request->data['Post']['tags']);
        foreach ($tags as $_tag) {
            $tagName = trim($_tag);
            $tagSlug = strtolower(Inflector::slug($tagName, '-'));
            if ($_tag) {
                // check if the tag exists
                $this->Post->Tag->recursive = -1;
                $tag = $this->Post->Tag->findBySlug($tagSlug);
                if (!$tag) {
                    // create new tag
                    $this->Post->Tag->create();
                    $tag = $this->Post->Tag->save(array('name' => $tagName, 'slug' => $tagSlug));
                    $tag['Tag']['id'] = $this->Post->Tag->id;
                    if (!$tag) {
                        $this->Session->setFlash(__(sprintf('The Tag %s could not be saved.', $_tag)), 'flash_error');
                    }
                }
                if ($tag) {
                    // use current tag
                    $this->request->data['Tag']['Tag'][$tag['Tag']['id']] = $tag['Tag']['id'];
                }
            }
        }


        // prevent the current tags from being deleted
        //$this->Post->hasAndBelongsToMany['Tag']['unique'] = false;
    }

    private function _loadTags() {
        // load the habtm data for the textarea
        $tags = array();
        if (isset($this->request->data['Tag']) && !empty($this->request->data['Tag'])) {
            foreach ($this->request->data['Tag'] as $tag) {
                $tags[] = $tag['name'];
            }
            $this->request->data['Post']['tags'] = implode(', ', $tags);
        }
    }

    /**
     * admin_filter method
     *
     * @param string $action
     * @return void
     */
    public function admin_filter($action = null) {
        $this->Post->recursive = 0;
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __('Posts Published'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'publish',
                    'Post.type' => 'post'
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __('Draft Posts'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'draft',
                    'Post.type' => 'post'
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __('Posts'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'trash',
                    'Post.type' => 'post'
                );
                break;

            default:
                $this->set('title_for_layout', __('Posts'));
                $this->paginate['conditions'] = array(
                    'Post.status' => array('publish', 'draft'),
                    'Post.type' => 'post'
                );
                break;
        }

        $this->paginate['order'] = array('Post.created' => 'desc');
        $this->set('posts', $this->paginate('Post'));
        $this->render('admin_index');
    }

    public function admin_process() {
        $this->autoRender = false;
        $action = $this->request->data['Post']['action'];
        $ids = array();
        foreach ($this->request->data['Post'] AS $id => $value) {
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
            case 'delete':
                if ($this->Post->deleteAll(array('Post.id' => $ids), true, true)) {
                    $this->Session->setFlash(__('Posts deleted.'), 'flash_notice');
                }
                break;

            case 'publish':
                if ($this->Post->updateAll(array('Post.status' => "'publish'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__('Posts published'), 'flash_notice');
                }
                break;

            case 'draft':
                if ($this->Post->updateAll(array('Post.status' => "'draft'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__('Posts drafted'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Post->updateAll(array('Post.status' => "'trash'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__('Posts move to trash'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__('An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}
