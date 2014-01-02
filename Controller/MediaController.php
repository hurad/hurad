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
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Class MediaController
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
     * Add media
     */
    public function admin_add()
    {
        $this->set('title_for_layout', __d('hurad', 'Add Media'));

        if ($this->request->is('post')) {
            $prefix = uniqid() . '_';
            $upload = $this->request->data['Media']['file'];
            $path = date('Y') . DS . date('m');

            if ($upload['error']) {
                $this->redirect(['action' => 'index']);
                $this->Session->setFlash(
                    __d('hurad', 'File could not be uploaded. Please, try again.'),
                    'flash_message',
                    ['class' => 'danger']
                );
            }

            $folder = new Folder(WWW_ROOT . 'files' . DS . $path, true, 0755);
            move_uploaded_file($upload['tmp_name'], $folder->pwd() . DS . $prefix . $upload['name']);

            $file = new File($folder->pwd() . DS . $prefix . $upload['name']);

            $this->request->data['Media']['user_id'] = $this->Auth->user('id');
            $this->request->data['Media']['name'] = $prefix . $upload['name'];
            $this->request->data['Media']['original_name'] = $upload['name'];
            $this->request->data['Media']['mime_type'] = $file->mime();
            $this->request->data['Media']['size'] = $file->size();
            $this->request->data['Media']['extension'] = $file->ext();
            $this->request->data['Media']['path'] = $path;
            $this->request->data['Media']['web_path'] = Configure::read(
                    'General.site_url'
                ) . '/' . 'files' . '/' . $path . '/' . $prefix . $upload['name'];

            $this->Media->create();
            if ($this->Media->save($this->request->data)) {
                $this->redirect(['action' => 'index']);
            }
        }
    }

    public function admin_delete($id)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $media = $this->Media->getMedia($id);

        if ($this->Media->delete()) {
            $file = new File(WWW_ROOT . 'files' . DS . $media['Media']['path'] . DS . $media['Media']['name']);

            if ($file->exists()) {
                $file->delete();
                if ($file->Folder->dirsize() <= 0) {
                    $file->Folder->delete();
                }
            }

            $this->Session->setFlash(__d('hurad', 'Media file deleted'), 'flash_message', ['class' => 'success']);
            $this->redirect($this->request->referer());
        }
        $this->Session->setFlash(
            __d('hurad', 'Media file was not deleted'),
            'flash_message',
            ['class' => 'danger']
        );
        $this->redirect($this->request->referer());
    }

    public function admin_download($id)
    {
        $file = $this->Media->getMedia($id);
        $this->response->file(
            WWW_ROOT . 'files' . DS . $file['Media']['path'] . DS . $file['Media']['name'],
            ['download' => true, 'name' => $file['Media']['original_name']]
        );

        return $this->response;
    }

    public function admin_browse($type = null)
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
            $this->Paginator->settings = $this->paginate;
        }

        $this->Media->recursive = 0;

        $this->set('media', $this->Paginator->paginate('Media'));
    }
}
