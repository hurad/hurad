<?php

App::uses('Akismet', 'Akismet.Lib');

/**
 * Class AkismetController
 */
class AkismetController extends AkismetAppController
{

    public $components = ['Role'];
    public $uses = ['Option'];

    public function isAuthorized($user)
    {
        switch ($user['role']) {
            case "administrator":
                return $this->Role->allowAuth();
                break;
            case "editor":
            case "author":
            case "user":
            default:
                return $this->Role->denyAuth();
                break;
        }
    }

    public function admin_index()
    {
        $apiKey = Configure::read('Akismet.api_key');
        if (Configure::check('Akismet.api_key') && !empty($apiKey)) {
            $data = [
                'blog' => Configure::read('General.site_url'),
                'key' => Configure::read('Akismet.api_key')
            ];
            $this->set('isValid', Akismet::isVerifyAPIKey($data));
        }

        if (!empty($this->request->data)) {
            if (isset($this->request->data['Akismet']['api_key'])) {
                if ($this->Option->write('Akismet.api_key', $this->request->data['Akismet']['api_key'])) {
                    $this->Session->setFlash(
                        __d('akismet', 'Akismet config have been updated!'),
                        'flash_message',
                        ['class' => 'success']
                    );
                    $this->redirect($this->referer());
                } else {
                    $this->Session->setFlash(
                        __d('akismet', 'Unable to update config.'),
                        'flash_message',
                        ['class' => 'danger']
                    );
                }
            }
        } else {
            $this->request->data['Akismet'] = Configure::read('Akismet');
        }
    }
}
