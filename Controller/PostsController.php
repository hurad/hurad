<?php
/**
 * Posts Controller
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

/**
 * Class PostsController
 *
 * @property Post $Post
 * @property Category $Category
 * @property PostsTag $PostsTag
 * @property Tag $Tag
 */
class PostsController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses.
     *
     * @var array
     */
    public $helpers = array('Post', 'Comment', 'Text', 'Editor');
    /**
     * Other components utilized by CommentsController
     *
     * @var array
     */
    public $components = array('RequestHandler', 'Role', 'Hurad', 'Paginator');
    /**
     * Paginate settings
     *
     * @var array
     */
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

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'viewById');
        $this->Security->unlockedFields = array('Post.tcheckbox', 'Post.bcheckbox');
    }

    /**
     * List of posts
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
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                array(
                    'Post' => array(
                        'conditions' => array(
                            'Post.status' => array('publish'),
                        ),
                        'contain' => array('Category', 'User', 'Tag', 'Comment'),
                    )
                )
            );
            $this->set('posts', $this->Paginator->paginate('Post'));
        }
    }

    /**
     * View post
     *
     * @param null|string $slug
     *
     * @throws NotFoundException
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

    /**
     * View post filtered by post id
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
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

    /**
     * List of posts filtered by user id
     *
     * @param null|int $userId
     *
     * @throws NotFoundException
     */
    public function admin_listByAuthor($userId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->User->id = $userId;
        if (is_null($userId) || !$this->Post->User->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid author'));
        }
        $this->Post->recursive = 1;
        $this->Paginator->settings = Hash::merge(
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

    /**
     * List of posts filtered by category id
     *
     * @param null|int $categoryId
     *
     * @throws NotFoundException
     */
    public function admin_listByCategory($categoryId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->Category->id = $categoryId;
        if (is_null($categoryId) || !$this->Post->Category->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid category'));
        }
        $this->Paginator->settings = Hash::merge(
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

    /**
     * List of posts filtered by tag id
     *
     * @param null|int $tagId
     *
     * @throws NotFoundException
     */
    public function admin_listByTag($tagId = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->Tag->id = $tagId;
        if (is_null($tagId) || !$this->Post->Tag->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid tag'));
        }
        $this->Paginator->settings = Hash::merge(
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
     * List of posts
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Posts'));
        $this->Post->recursive = 1;
        if (isset($this->request->params['named']['q'])) {
            App::uses('Sanitize', 'Utility');
            $q = Sanitize::clean($this->request->params['named']['q']);
            $this->Paginator->settings = Hash::merge(
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
     * Add post
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
                $this->Session->setFlash(
                    __d('hurad', 'The post has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The post could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
        $categories = $this->Post->Category->generateTreeList(null, null, null, '_');
        $this->set(compact('categories'));
    }

    /**
     * Edit post
     *
     * @param null|int $id
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
                $this->Session->setFlash(
                    __d('hurad', 'The Post has been saved.'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The Post could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
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
     * Delete post
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
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
            $this->Session->setFlash(__d('hurad', 'Post deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Post was not deleted'), 'flash_message', array('class' => 'danger'));
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
                        $this->Session->setFlash(
                            __(sprintf('The Tag %s could not be saved.', $_tag)),
                            'flash_message',
                            array('class' => 'danger')
                        );
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
     * Filter posts
     *
     * @param null|string $action
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

    /**
     * Post processes
     */
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
            $this->Session->setFlash(__d('hurad', 'No items selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        } elseif ($action == null) {
            $this->Session->setFlash(__d('hurad', 'No action selected.'), 'flash_message', array('class' => 'warning'));
            $this->redirect(array('action' => 'index'));
        }

        switch ($action) {
            case 'delete':
                if ($this->Post->deleteAll(array('Post.id' => $ids), true, true)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Posts deleted.'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'publish':
                if ($this->Post->updateAll(array('Post.status' => "'publish'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Posts published'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'draft':
                if ($this->Post->updateAll(array('Post.status' => "'draft'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Posts drafted'),
                        'flash_message',
                        array('class' => 'success')
                    );
                }
                break;

            case 'trash':
                if ($this->Post->updateAll(array('Post.status' => "'trash'"), array('Post.id' => $ids))) {
                    $this->Session->setFlash(
                        __d('hurad', 'Posts move to trash'),
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