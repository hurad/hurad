<?php
/**
 * Tags Controller
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

/**
 * Class TagsController
 *
 * @property Tag $Tag
 */
class TagsController extends AppController
{
    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     */
    public $components = ['Paginator'];

    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = [
        'Tag' => [
            'limit' => 25,
            'order' => [
                'Tag.created' => 'desc'
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
        $this->Auth->allow('index');
    }

    /**
     * List of tags
     */
    public function index()
    {
        if ($this->request->is('ajax')) {
            Configure::write('debug', 0);
            $this->autoRender = false;
            $tags = $this->Tag->find('all', array('conditions' => array('Tag.name LIKE' => '%' . $_GET['term'] . '%')));
            $i = 0;
            foreach ($tags as $tag) {
                $response[$i]['value'] = $tag['Tag']['name'];
                $response[$i]['label'] = $tag['Tag']['name'];
                $i++;
            }
            echo json_encode($response);
        } else {
            $this->Tag->recursive = 0;
            $this->set('tags', $this->Paginator->paginate('Tag'));
        }
    }

    /**
     * List of tags
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Tags'));
        $this->Tag->recursive = 0;
        $this->set('tags', $this->Paginator->paginate('Tag'));
    }

    /**
     * Add tag
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Tag'));
        if ($this->request->is('post')) {
            if ($this->request->data['Tag']['slug']) {
                $this->request->data['Tag']['slug'] = strtolower(
                    Inflector::slug($this->request->data['Tag']['slug'], '-')
                );
            }
            $this->Tag->create();
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The tag has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The tag could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        }
    }

    /**
     * Edit tag
     *
     * @param null|int $id
     *
     * @throws NotFoundException
     */
    public function admin_edit($id = null)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit Tag'));
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid tag'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tag->save($this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The tag has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The tag could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->Tag->read(null, $id);
        }
        $posts = $this->Tag->Post->find('list');
        $this->set(compact('posts'));
    }

    /**
     * Delete tag
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
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid tag'));
        }
        if ($this->Tag->delete()) {
            $this->Session->setFlash(__d('hurad', 'Tag deleted'), 'flash_message', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__d('hurad', 'Tag was not deleted'), 'flash_message', array('class' => 'danger'));
        $this->redirect(array('action' => 'index'));
    }
}
