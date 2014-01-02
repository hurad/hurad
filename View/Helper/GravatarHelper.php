<?php
/**
 * Gravatar helper
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
App::uses('AppHelper', 'View/Helper');

/**
 * Class GravatarHelper
 */
class GravatarHelper extends AppHelper
{
    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html'];
    const GRAVATAR_URL = 'http://www.gravatar.com/avatar/';

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
        $email = md5(strtolower(trim($email)));
        $imageSrc = self::GRAVATAR_URL . $email . '?' . $optionsQuery;

        if (Configure::read('Comment-avatar_default') == 'gravatar_default') {
            $opt = array(
                'size' => $options['size']
            );
            $email = '00000000000000000000000000000000';
            $optionsQuery = http_build_query($opt);
            $imageSrc = self::GRAVATAR_URL . $email . '?' . $optionsQuery;
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
