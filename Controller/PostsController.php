<?php
/**
 * Posts Controller
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2012-2014, Hurad (http://hurad.org)
 * @link      http://hurad.org Hurad Project
 * @since     Version 0.1.0
 * @license   http://opensource.org/licenses/MIT MIT license
 */
App::uses('AppController', 'Controller');
App::uses('Post', 'Model');

/**
 * Class PostsController
 *
 * @property Post     $Post
 * @property Category $Category
 * @property PostsTag $PostsTag
 * @property Tag      $Tag
 */
class PostsController extends AppController
{
    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the class name.
     *
     * Example: `public $helpers = array('Html', 'Js', 'Time', 'Ajax');`
     *
     * @var mixed A single name as a string or a list of names as an array.
     */
    public $helpers = ['Content', 'Comment', 'Text', 'Editor' => ['name' => 'data[Post][content]'], 'Utils.Tree'];

    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     */
    public $components = ['RequestHandler', 'Hurad', 'Paginator'];

    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = [
        'Post' => [
            'conditions' => [
                'Post.status' => [Post::STATUS_PUBLISH, Post::STATUS_PENDING, Post::STATUS_DRAFT],
                'Post.type' => 'post'
            ],
            'limit' => 25,
            'order' => [
                'Post.created' => 'desc'
            ]
        ]
    ];

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view', 'viewById', 'indexByTaxonomy');
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
                        'Post.status' => Post::STATUS_PUBLISH,
                        'Post.type' => 'post',
                    )
                )
            );
            $this->set(compact('posts'));

        } else {
            if (Configure::check('Read.show_posts_per_page')) {
                $limit = Configure::read('Read.show_posts_per_page');
            } else {
                $limit = 5;
            }

            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                [
                    'Post' => [
                        'conditions' => [
                            'Post.status' => Post::STATUS_PUBLISH,
                        ],
                        'limit' => $limit,
                        'contain' => ['Category', 'User', 'Tag', 'Comment'],
                        'order' => ['Post.sticky' => 'DESC'],
                    ]
                ]
            );

            $this->set('posts', $this->Paginator->paginate('Post'));
        }
    }

    public function indexByTaxonomy($type, $slug = null)
    {
        switch ($type) {
            case 'category':
                if ($this->Post->Category->getBySlug($slug)) {
                    $id = $this->Post->Category->getBySlug($slug)['Category']['id'];
                } else {
                    throw new NotFoundException();
                }

                $conditions = [];
                $joins = [
                    array(
                        'type' => 'inner',
                        'table' => 'categories_posts',
                        'alias' => 'CategoriesPost',
                        'conditions' => array(
                            'CategoriesPost.post_id = Post.id',
                            'CategoriesPost.category_id' => $id
                        )
                    )
                ];
                break;

            case 'tag':
                if ($this->Post->Tag->getBySlug($slug)) {
                    $id = $this->Post->Tag->getBySlug($slug)['Tag']['id'];
                } else {
                    throw new NotFoundException();
                }

                $conditions = [];
                $joins = [
                    array(
                        'type' => 'inner',
                        'table' => 'posts_tags',
                        'alias' => 'PostsTag',
                        'conditions' => array(
                            'PostsTag.post_id = Post.id',
                            'PostsTag.tag_id' => $id
                        )
                    )
                ];
                break;

            case 'author':
                $conditions = ['Post.status' => [Post::STATUS_PUBLISH], ['User.username' => $slug]];
                $joins = [];
                break;

            default:
                throw new NotFoundException();
                break;
        }

        $this->Paginator->settings = Hash::merge(
            $this->paginate,
            array(
                'Post' => array(
                    'conditions' => $conditions,
                    'joins' => $joins,
                    'contain' => array('Category', 'User', 'Tag', 'Comment'),
                )
            )
        );

        $this->set('posts', $this->Paginator->paginate('Post'));
        $this->render('index');
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
        $slug = HuradSanitize::title($slug, 'dash', '');
        $post = $this->Post->findBySlug($slug);

        if (!$post) {
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
        $this->Paginator->settings = $this->paginate;
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
            'status' => Post::STATUS_DRAFT,
            'comment_status' => Post::COMMENT_STATUS_OPEN,
            'comment_count' => 0,
            'type' => 'post',
        );

        if ($this->request->is('post')) {
            $this->request->data['Post']['created'] = $this->Hurad->dateParse($this->request->data['Post']['created']);
            $this->request->data['Post'] = Hash::merge($defaults, $this->request->data['Post']);
            // get the tags from the text data
            if ($this->request->data['Post']['tags']) {
                $this->_saveTags();
            }
            // prevent the current tags from being deleted
            $this->Post->hasAndBelongsToMany['Tag']['unique'] = false;

            if (empty($this->request->data['Post']['slug'])) {
                $this->request->data['Post']['slug'] = HuradSanitize::title(
                    $this->request->data['Post']['title'],
                    'dash'
                );
            } else {
                $this->request->data['Post']['slug'] = HuradSanitize::title(
                    $this->request->data['Post']['slug'],
                    'dash'
                );
            }

            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Post->PostMeta->post_id = $this->Post->getLastInsertID();
                $this->Post->PostMeta->saveData($this->request->data);

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
            'status' => Post::STATUS_DRAFT,
            'comment_status' => Post::COMMENT_STATUS_OPEN,
            'comment_count' => 0,
            'type' => 'post',
        );

        if (!empty($this->request->data)) {
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['Post'] = Hash::merge($defaults, $this->request->data['Post']);
                $this->request->data['Post']['created'] = $this->Hurad->dateParse(
                    $this->request->data['Post']['created']
                );
                if (empty($this->request->data['Post']['tags'])) {
                    $this->loadModel('PostsTag');
                    $this->PostsTag->deleteAll(array('post_id' => $id), false);
                }
            }

            $this->_saveTags();

            if (empty($this->request->data['Post']['slug'])) {
                $this->request->data['Post']['slug'] = HuradSanitize::title(
                    $this->request->data['Post']['title'],
                    'dash'
                );
            } else {
                $this->request->data['Post']['slug'] = HuradSanitize::title(
                    $this->request->data['Post']['slug'],
                    'dash'
                );
            }

            // save the data
            $this->Post->create();
            $this->Post->PostMeta->post_id = $id;

            if ($this->Post->save($this->request->data) && $this->Post->PostMeta->saveData($this->request->data)) {
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
        $this->Post->PostMeta->post_id = $id;
        $post = Hash::merge($this->Post->read(null, $id), $this->Post->PostMeta->getData());
        $categories = $this->Post->Category->generateTreeList();
        $this->request->data = $post;
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

    protected function _fallbackView($viewName)
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

        switch ($action) {
            case 'publish':
                $this->set('title_for_layout', __d('hurad', 'Posts Published'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Post' => [
                            'conditions' => [
                                'Post.status' => Post::STATUS_PUBLISH
                            ]
                        ]
                    ]
                );
                break;

            case 'draft':
                $this->set('title_for_layout', __d('hurad', 'Draft Posts'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Post' => [
                            'conditions' => [
                                'Post.status' => Post::STATUS_DRAFT
                            ]
                        ]
                    ]
                );
                break;

            case 'trash':
                $this->set('title_for_layout', __d('hurad', 'Posts'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Post' => [
                            'conditions' => [
                                'Post.status' => Post::STATUS_TRASH
                            ]
                        ]
                    ]
                );
                break;

            default:
                $this->set('title_for_layout', __d('hurad', 'Posts'));
                $this->Paginator->settings = Hash::merge(
                    $this->paginate,
                    [
                        'Post' => [
                            'conditions' => [
                                'Post.status' => [Post::STATUS_PUBLISH, Post::STATUS_DRAFT]
                            ]
                        ]
                    ]
                );
                break;
        }

        $this->set('posts', $this->Paginator->paginate('Post'));
        $this->render('admin_index');
    }
}
