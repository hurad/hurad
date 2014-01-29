<?php
/**
 * Media model
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
App::uses('AppModel', 'Model');

/**
 * Class Media
 */
class Media extends AppModel
{
    /**
     * The displayField attribute specifies which database field should be used as a label for the record.
     * The label is used in scaffolding and in find('list') calls.
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Define a belongsTo association in the Post model in order to get access to related User data.
     *
     * @var array
     */
    public $belongsTo = [
        'User' => [
            'className' => 'User',
            'foreignKey' => 'user_id'
        ]
    ];

    /**
     * List of validation rules. It must be an array with the field name as key and using
     * as value one of the following possibilities
     *
     * @var array
     */
    public $validate = [
        'media_file' => [
            'uploadError' => [
                'rule' => 'uploadError',
                'message' => 'Something went wrong with the upload.'
            ]
        ],
    ];

    /**
     * Get media
     *
     * @param int $mediaId Media id
     *
     * @return array
     * @throws NotFoundException
     */
    public function getMedia($mediaId)
    {
        $this->id = $mediaId;
        if (!$this->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid media file'));
        }

        return $this->find('first', ['conditions' => ['Media.id' => $mediaId]]);
    }

    /**
     * Add media file
     *
     * @param array $requestData Array of POST data. Will contain form data as well as uploaded files.
     *
     * @return bool
     * @throws CakeException
     */
    public function addMedia(array $requestData)
    {
        if (CakeNumber::fromReadableSize(ini_get('post_max_size')) < env('CONTENT_LENGTH')) {
            throw new CakeException(__d(
                'hurad',
                'File could not be uploaded. please increase "post_max_size" in php.ini'
            ));
        }

        $this->set($requestData);

        if ($this->validates()) {
            $prefix = uniqid() . '_';
            $uploadInfo = $requestData['Media']['media_file'];
            $path = date('Y') . DS . date('m');

            if ($uploadInfo['error']) {
                throw new CakeException($this->getUploadErrorMessages($uploadInfo['error']));
            }

            $folder = new Folder(WWW_ROOT . 'files' . DS . $path, true, 0755);
            if (!is_writable(WWW_ROOT . 'files')) {
                throw new CakeException(__d('hurad', '%s is not writable', WWW_ROOT . 'files'));
            }

            if (!move_uploaded_file($uploadInfo['tmp_name'], $folder->pwd() . DS . $prefix . $uploadInfo['name'])) {
                throw new CakeException(__d('hurad', 'File could not be uploaded. Please, try again.'));
            }

            $file = new File($folder->pwd() . DS . $prefix . $uploadInfo['name']);

            $requestData['Media']['user_id'] = CakeSession::read('Auth.User.id');
            $requestData['Media']['name'] = $prefix . $uploadInfo['name'];
            $requestData['Media']['original_name'] = $uploadInfo['name'];
            $requestData['Media']['mime_type'] = $file->mime();
            $requestData['Media']['size'] = $file->size();
            $requestData['Media']['extension'] = $file->ext();
            $requestData['Media']['path'] = $path;
            $requestData['Media']['web_path'] = Configure::read(
                    'General.site_url'
                ) . '/' . 'files' . '/' . $path . '/' . $prefix . $uploadInfo['name'];

            $this->create();
            if ($this->save($requestData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Edit media file
     *
     * @param int   $mediaId     Media id
     * @param array $requestData Array of POST data.
     *
     * @return bool
     * @throws NotFoundException
     */
    public function editMedia($mediaId, array $requestData)
    {
        $this->id = $mediaId;
        if (!$this->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid media file.'));
        }

        if ($this->save($requestData)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete media file
     *
     * @param int $mediaId Media id
     *
     * @return bool
     * @throws NotFoundException
     */
    public function deleteMedia($mediaId)
    {
        $this->id = $mediaId;
        if (!$this->exists()) {
            throw new NotFoundException(__d('hurad', 'Invalid media file.'));
        }

        $media = $this->getMedia($mediaId);

        if ($this->delete()) {
            $file = new File(WWW_ROOT . 'files' . DS . $media['Media']['path'] . DS . $media['Media']['name']);

            if ($file->exists()) {
                $file->delete();
                if ($file->Folder->dirsize() <= 0) {
                    $file->Folder->delete();
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get upload error message
     *
     * @param int $uploadError Upload error code
     *
     * @return string
     */
    protected function getUploadErrorMessages($uploadError)
    {
        switch ($uploadError) {
            case UPLOAD_ERR_INI_SIZE:
                $message = __d('hurad', 'The uploaded file exceeds the upload_max_filesize directive in php.ini');
                break;

            case UPLOAD_ERR_FORM_SIZE:
                $message = __d(
                    'hurad',
                    'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.'
                );
                break;

            case UPLOAD_ERR_PARTIAL:
                $message = __d('hurad', 'The uploaded file was only partially uploaded.');
                break;

            case UPLOAD_ERR_NO_FILE:
                $message = __d('hurad', 'No file was uploaded.');
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                $message = __d('hurad', 'Missing a temporary folder.');
                break;

            case UPLOAD_ERR_CANT_WRITE:
                $message = __d('hurad', 'Failed to write file to disk.');
                break;

            case UPLOAD_ERR_EXTENSION:
                $message = __d('hurad', 'A PHP extension stopped the file upload.');
                break;

            default:
                $message = __d('hurad', 'File could not be uploaded. Please, try again.');
                break;
        }

        return $message;
    }
}
