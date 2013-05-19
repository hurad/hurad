<?php

/**
 * Description of AkismetBehavior
 *
 * @author mohammad
 */
class AkismetBehavior extends ModelBehavior {

    public function setup(\Model $model, $config = array()) {
        parent::setup($model, $config);
    }

    public function beforeSave(\Model $model) {
        parent::beforeSave($model);
        $request = new CakeRequest();
        $data = array(
            'blog' => urlencode(Configure::read('General.site_url')),
            'user_ip' => urlencode($model->data[$model->alias]['author_ip']),
            'user_agent' => urlencode($model->data[$model->alias]['agent']),
            'referrer' => urlencode($request->referer()),
            'permalink' => urlencode($request->referer()),
            'comment_type' => urlencode('comment'),
            'comment_author' => urlencode($model->data[$model->alias]['author']),
            'comment_author_email' => urlencode($model->data[$model->alias]['author_email']),
            'comment_author_url' => urlencode($model->data[$model->alias]['author_url']),
            'comment_content' => urlencode($model->data[$model->alias]['content'])
        );

        if (Akismet::isSpam($data, Configure::read('Akismet.api_key'))) {
            $model->data[$model->alias]['approved'] = 'spam';
        }
    }

}