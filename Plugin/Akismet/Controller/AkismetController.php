<?php

App::uses('Akismet', 'Akismet.Lib');

/**
 * Description of AkismetController
 *
 * @author mohammad
 */
class AkismetController extends AkismetAppController
{

    public $uses = array('Option');

    public function isAuthorized($user)
    {
        return true;
    }

    public function admin_index()
    {

        $apiKey = Configure::read('Akismet.api_key');
        if (Configure::check('Akismet.api_key') && !empty($apiKey)) {
            $data = array(
                'blog' => Configure::read('General.site_url'),
                'key' => Configure::read('Akismet.api_key')
            );
            $this->set('isValid', Akismet::isVerifyAPIKey($data));
        }

        if (!empty($this->request->data)) {
            if (isset($this->request->data['Akismet']['api_key'])) {
                if ($this->Option->write('Akismet.api_key', $this->request->data['Akismet']['api_key'])) {
                    $this->Session->setFlash(__('Akismet config have been updated!'), 'success');
                    $this->redirect($this->referer());
                } else {
                    $this->Session->setFlash(__('Unable to update config.'), 'error');
                }
            }
        } else {
            $this->request->data['Akismet'] = Configure::read('Akismet');
        }
    }

}