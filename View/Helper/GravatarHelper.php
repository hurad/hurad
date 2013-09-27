<?php

App::uses('AppHelper', 'View/Helper');

class GravatarHelper extends AppHelper
{

    public $helpers = array('Html');

    public function image($email, $options)
    {
        $defaults = array(
            'size' => 45,
            'default' => Configure::read('Comment-avatar_default'),
            'rating' => Configure::read('Comment-avatar_rating'),
            'alt' => __d('hurad', 'Avatar'),
            'class' => 'avatar',
            'echo' => true
        );
        $options = Hash::merge($defaults, $options);

        $optionsQuery = http_build_query($options);
        $gravatarUrl = "http://www.gravatar.com/avatar/";
        $email = md5(strtolower(trim($email)));
        $imageSrc = $gravatarUrl . $email . '?' . $optionsQuery;

        if (Configure::read('Comment-avatar_default') == 'gravatar_default') {
            $opt = array(
                'size' => $options['size']
            );
            $email = '00000000000000000000000000000000';
            $optionsQuery = http_build_query($opt);
            $imageSrc = $gravatarUrl . $email . '?' . $optionsQuery;
        }

        if ($options['echo']) {
            echo $this->Html->image($imageSrc, array('alt' => $options['alt'], 'class' => $options['class']));
        } else {
            return $this->Html->image($imageSrc, array('alt' => $options['alt'], 'class' => $options['class']));
        }
    }

    public function profile($email)
    {
        $requestUrl = "http://www.gravatar.com/";
        $email = md5(strtolower(trim($email)));
        $profileUrl = $requestUrl . $email . '.php';

        $str = file_get_contents($profileUrl);
        $profile = unserialize($str);

        return $profile['entry'][0];
    }

}