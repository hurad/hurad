<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 * @property Category $Category
 * @property PostsTag $PostsTag
 * @property Tag $Tag
 */
class PostsController extends AppController
{

    public $helpers = array('Post', 'Comment', 'Text', 'Editor');
    public $components = array('RequestHandler', 'Role', 'Hurad', 'Paginator');
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

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'viewById');
        $this->Security->unlockedFields = array('Post.tcheckbox', 'Post.bcheckbox');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->RequestHandler->isRss()) {
            $posts = $this->Post->find(
                'all',
                array(
                    'limit' => 20,
                    'order' => 'Post.created DESC',
                    'conditions' => array(
                        'Post.status' => 'publish',
                        'Post.type' => 'post',
                    )
                )
            );
            $this->set(compact('posts'));
        } else {
            $this->paginate = array(
                'conditions' => array(
                    'Post.status' => array('publish'),
                    'Post.type' => 'post'
                ),
                'contain' => array('Category', 'User', 'Tag', 'Comment'),
                'order' => array(
                    'Post.created' => 'desc'
                )
            );
            $this->set('posts', $this->paginate('Post'));
        }
    }

    /**
     * view method
     *
     * @param null $slug
     *
     * @throws NotFoundException
     * @internal param string $id
     *
     * @return void
     */
    public function view($slug = null)
    {
        $slug = Formatting::sanitize_title($slug);
        $this->Post->slug = $slug;
        if (is_null($slug) && !$this->Post->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid post'));
        } else {
            $this->set('post', $this->Post->findBySlug($slug));
            $this->_fallbackView($slug);
        }
    }

    public function viewById($id = null)
    {
        $this->Post->id = $id;
        if (is_null($id) && !$this->Post->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid post'));
        }

        $this->set('post', $this->Post->read(null, $id));

        if (!$this->_fallbackView($id)) {
            $this->render('view');
        }
    }

    public function admin_listByAuthor($userId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->User->id = $userId;
        if (is_null($userId) || !$this->Post->User->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid author'));
        }
        $this->Post->recursive = 1;
        $this->Paginator->settings = array_merge(
            $this->paginate,
            array(
                'Post' => array(
                    'conditions' => array(
                        'Post.user_id' => $userId,
                    )
                )
            )
        );
        $this->set('posts', $this->Paginator->paginate('Post'));
        $this->render('admin_index');
    }

    public function admin_listByCategory($categoryId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->Category->id = $categoryId;
        if (is_null($categoryId) || !$this->Post->Category->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid category'));
        }
        $this->Paginator->settings = array_merge(
            $this->paginate,
            array(
                'Post' => array(
                    'conditions' => array(
                        'CategoriesPost.category_id' => $categoryId,
                    )
                )
            )
        );
        $this->Post->bindModel(array('hasOne' => array('CategoriesPost')), false);
        $this->set('posts', $this->Paginator->paginate('Post'));
        $this->render('admin_index');
    }

    public function admin_listByTag($tagId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->Tag->id = $tagId;
        if (is_null($tagId) || !$this->Post->Tag->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid tag'));
        }
        $this->Paginator->settings = array_merge(
            $this->paginate,
            array(
                'Post' => array(
                    'conditions' => array(
                        'PostsTag.tag_id' => $tagId,
                    )
                )
            )
        );
        $this->Post->bindModel(array('hasOne' => array('PostsTag')), false);
        $this->set('posts', $this->Paginator->paginate('Post'));
        $this->render('admin_index');
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->recursive = 1;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->Paginator->settings = array_merge(
                $this->paginate,
                array(
                    'Post' => array(
                        'conditions' => array('Post.title LIKE' => '%' . $q . '%')
                    )
                )
            );
        }
        $this->set('posts', $this->Paginator->paginate('Post'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Post'));

        $defaults = array(
            'parent_id' => null,
            'user_id' => $this->Auth->user('id'),
            'title' => '',
            'slug' => '',
            'content' => '',
            'excerpt' => '',
            'status' => 'draft',
            'comment_status' => 'open',
            'comment_count' => 0,
            'type' => 'post',
        );

        if ($this->request->is('post')) {
            $this->request->data['Post']['created'] = $this->Hurad->dateParse($this->request->data['Post']['created']);
            $this->request->data['Post'] = Functions::hr_parse_args($this->request->data['Post'], $defaults);
            // get the tags from the text data
            if ($this->request->data['Post']['tags']) {
                $this->_saveTags();
            }
            // prevent the current tags from being deleted
            $this->Post->hasAndBelongsToMany['Tag']['unique'] = false;

            if (empty($this->request->data['Post']['slug'])) {
                if (!in_array($this->request->data['Post']['status'], array('draft'))) {
                    $this->request->data['Post']['slug'] = Formatting::sanitize_title(
                        $this->request->data['Post']['title']
                    );
                } else {
                    $this->request->data['Post']['slug'] = '';
                }
            } else {
                $this->request->data['Post']['slug'] = Formatting::sanitize_title($this->request->data['Post']['slug']);
            }

            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__d('hurad', 'The post has been saved'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The post could not be saved. Please, try again.'), 'error');
            }
        }
        $categories = $this->Post->Category->generateTreeList(null, null, null, '_');
        $this->set(compact('categories'));
    }

    /**
     * admin_edit method
     *
     * @param string $id
     *
     * @return void
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Post'));

        $defaults = array(
            'parent_id' => null,
            'user_id' => $this->Auth->user('id'),
            'title' => '',
            'slug' => '',
            'content' => '',
            'excerpt' => '',
            'status' => 'draft',
            'comment_status' => 'open',
            'comment_count' => 0,
            'type' => 'post',
        );

        if (!empty($this->request->data)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['Post'] = Functions::hr_parse_args($this->request->data['Post'], $defaults);
                if (empty($this->request->data['Post']['tags'])) {
                    $this->loadModel('PostsTag');
                    $this->PostsTag->deleteAll(array('post_id' => $id), false);
                }
            }

            $this->_saveTags();

            if (empty($this->request->data['Post']['slug'])) {
                if (!in_array($this->request->data['Post']['status'], array('draft'))) {
                    $this->request->data['Post']['slug'] = Formatting::sanitize_title(
                        $this->request->data['Post']['title']
                    );
                } else {
                    $this->request->data['Post']['slug'] = '';
                }
            } else {
                $this->request->data['Post']['slug'] = Formatting::sanitize_title($this->request->data['Post']['slug']);
            }

            // save the data
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__d('hurad', 'The Post has been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__d('hurad', 'The Post could not be saved. Please, try again.'), 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Post->read(null, $id);
            // load the habtm data for the text input.
            $this->_loadTags();
        }

        // get the posts current tags
        $post = $id ? $this->Post->find('first', array('conditions' => array('Post.id' => $id))) : false;
        $categories = $this->Post->Category->generateTreeList();
        $this->set(compact('post', 'categories'));
    }

    /**
     * admin_delete method
     *
     * @param string $id
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @return void
     */
    public function admin_delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Post->id = $id;
        if (!$this->Post->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid post'));
        }
        if ($this->Post->delete()) {
            $this->Session->setFlash(__d('hurad', 'Post deleted'), 'flash_notice');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Post was not deleted'), 'flash_error');
        $this->redirect(array('action' => 'index'));
    }

    private function _saveTags()
    {
        // get the tags from the text data
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
    }

    private function _loadTags()
    {
        // load the habtm data for the textarea
        $tags = array();
        if (isset($this->request->data['Tag']) && !empty($this->request->data['Tag'])) {
            foreach ($this->request->data['Tag'] as $tag) {
                $tags[] = $tag['name'];
            }
            $this->request->data['Post']['tags'] = implode(', ', $tags);
        }
    }

    private function _fallbackView($viewName)
    {
        if (file_exists(
            APP . 'View' . DS . 'Themed' . DS . Configure::read(
                'template'
            ) . DS . 'Posts' . DS . 'view-' . $viewName . '.ctp'
        )
        ) {
            $this->render('view-' . $viewName);
            return true;
        }
        return false;
    }

    /**
     * admin_filter method
     *
     * @param string $action
     *
     * @return void
     */
    public function admin_filter($action = null)
    {
        $this->Post->recursive = 1;
        $this->paginate = array();
        $this->paginate['limit'] = 25;
        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __d('hurad', 'Posts Published'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'publish',
                    'Post.type' => 'post'
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __d('hurad', 'Draft Posts'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'draft',
                    'Post.type' => 'post'
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __d('hurad', 'Posts'));
                $this->paginate['conditions'] = array(
                    'Post.status' => 'trash',
                    'Post.type' => 'post'
                );
                break;

            default:
                $this->set('title_for_layout', __d('hurad', 'Posts'));
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

    public function admin_process()
    {
        $this->autoRender = false;
        $action = null;
        if ($this->request->data['Post']['action']) {
            $action = $this->request->data['Post']['action'];
        }
        $ids = array();
        foreach ($this->request->data['Post'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0) {
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_error');
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Post->deleteAll(array('Post.id' => $ids), true, true)) {
                    $this->Session->setFlash(__d('hurad', 'Posts deleted.'), 'flash_notice');
                }
                break;

            case 'publish':
                if ($this->Post->updateAll(array('Post.status' => "'publish'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Posts published'), 'flash_notice');
                }
                break;

            case 'draft':
                if ($this->Post->updateAll(array('Post.status' => "'draft'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Posts drafted'), 'flash_notice');
                }
                break;

            case 'trash':
                if ($this->Post->updateAll(array('Post.status' => "'trash'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(__d('hurad', 'Posts move to trash'), 'flash_notice');
                }
                break;

            default:
                $this->Session->setFlash(__d('hurad', 'An error occurred.'), 'flash_error');
                break;
        }
        $this->redirect(array('action' => 'index'));
    }

}