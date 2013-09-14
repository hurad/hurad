<?php
/**
 * Tags Controller
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
 * Class TagsController
 *
 * @property Tag $Tag
 */
class TagsController extends AppController
{
    /**
     * Other components utilized by CommentsController
     *
     * @var array
     */
    public $components = array('Paginator');
    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = array(
        'Tag' => array(
            'limit' => 25,
            'order' => array(
                'Tag.created' => 'desc'
            )
        )
    );

    /**
     * Called before the controller action.
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

    /**
     * Tag processes
     */
    public function admin_process()
    {
        $this->autoRender = false;
        $action = $this->request->data['Tag']['action'];
        $ids = array();
        foreach ($this->request->data['Tag'] AS $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        switch ($action) {
            case 'delete':
                if ($this->Tag->deleteAll(array('Tag.id' => $ids), true, true)) {
                    $this->Session->setFlash(
                        __d('hurad', 'Tags deleted.'),
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