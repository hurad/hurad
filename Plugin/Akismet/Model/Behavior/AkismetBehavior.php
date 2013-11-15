<?php

/**
 * Class AkismetBehavior
 */
class AkismetBehavior extends ModelBehavior
{
    /**
     * Setup this behavior with the specified configuration settings.
     *
     * @param Model $model Model using this behavior
     * @param array $config Configuration settings for $model
     *
     * @return void
     */
    public function setup(\Model $model, $config = [])
    {
        parent::setup($model, $config);
    }

    /**
     * beforeSave is called before a model is saved. Returning false from a beforeSave callback
     * will abort the save operation.
     *
     * @param Model $model Model using this behavior
     * @param array $options Options passed from Model::save().
     *
     * @return mixed|void
     */
    public function beforeSave(\Model $model, $options = array())
    {
        parent::beforeSave($model);
        $request = new CakeRequest();
        $data = [
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
        ];

        if (Akismet::isSpam($data, Configure::read('Akismet.api_key'))) {
            $model->data[$model->alias]['approved'] = 'spam';
        }
    }
}
