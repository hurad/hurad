<?php
/**
 * Media Controller
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
 * Class MediaController
 *
 * @property Media $Media
 */
class MediaController extends AppController
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
        'Media' => [
            'limit' => 25,
            'order' => [
                'Media.created' => 'desc'
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

        if ($this->request->params['action'] == 'admin_add') {
            $this->Security->csrfCheck = false;
        }
    }

    /**
     * List of media
     */
    public function admin_index()
    {
        $this->set('title_for_layout', __d('hurad', 'Media Library'));

        $this->Media->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('media', $this->Paginator->paginate('Media'));
    }

    /**
     * Add media file
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Media'));

        if ($this->request->is('post')) {
            try {
                if ($this->Media->addMedia($this->request->data)) {
                    $this->Session->setFlash(
                        __d('hurad', 'File successfully uploaded.'),
                        'flash_message',
                        ['class' => 'success']
                    );
                } else {
                    $this->Session->setFlash(
                        __d('hurad', 'File could not be uploaded. Please, try again.'),
                        'flash_message',
                        ['class' => 'danger']
                    );
                }

                $this->redirect(['action' => 'index']);
            } catch (CakeBaseException $e) {
                $this->Session->setFlash($e->getMessage(), 'flash_message', ['class' => 'danger']);
                $this->redirect(['action' => 'index']);
            }
        }
    }

    /**
     * Edit media file
     *
     * @param int $mediaId Media id
     */
    public function admin_edit($mediaId)
    {
        $this->set('title_for_layout', __d('hurad', 'Edit media'));

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Media->editMedia($mediaId, $this->request->data)) {
                $this->Session->setFlash(
                    __d('hurad', 'The media has been saved'),
                    'flash_message',
                    array('class' => 'success')
                );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(
                    __d('hurad', 'The media could not be saved. Please, try again.'),
                    'flash_message',
                    array('class' => 'danger')
                );
            }
        } else {
            $this->request->data = $this->Media->read(null, $mediaId);
        }
    }

    /**
     * Delete media file
     *
     * @param int $id Media id
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function admin_delete($id)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Media->deleteMedia($id)) {
            $this->Session->setFlash(__d('hurad', 'Media file deleted'), 'flash_message', ['class' => 'success']);
            $this->redirect($this->request->referer());
        } else {
            $this->Session->setFlash(
                __d('hurad', 'Media file was not deleted'),
                'flash_message',
                ['class' => 'danger']
            );
            $this->redirect($this->request->referer());
        }
    }

    /**
     * Download media
     *
     * @param int $mediaId Media id
     *
     * @return CakeResponse
     */
    public function admin_download($mediaId)
    {
        $file = $this->Media->getMedia($mediaId);
        $this->response->file(
            WWW_ROOT . 'files' . DS . $file['Media']['path'] . DS . $file['Media']['name'],
            ['download' => true, 'name' => $file['Media']['original_name']]
        );

        return $this->response;
    }

    /**
     * Browse media file
     *
     * @param string $type Browse type: image, movie, ...
     *
     * @throws MethodNotAllowedException
     */
    public function admin_browse($type)
    {
        $this->layout = 'browse';
        $this->set('title_for_layout', __d('hurad', 'Media Library'));

        if ($type == 'images') {
            $this->Paginator->settings = Hash::merge(
                $this->paginate,
                [
                    'Media' => [
                        'conditions' => [
                            'Media.mime_type' => ['image/jpeg', 'image/png', 'image/gif'],
                        ]
                    ]
                ]
            );
        } else {
            throw new MethodNotAllowedException();
        }

        $this->Media->recursive = 0;

        $this->set('media', $this->Paginator->paginate('Media'));
    }
}
