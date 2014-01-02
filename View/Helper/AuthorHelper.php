<?php
/**
 * Author helper
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
 * Class AuthorHelper
 */
class AuthorHelper extends AppHelper
{

    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Hook', 'Html', 'Link'];

    /**
     * Post author id
     *
     * @var intiger
     * @access public
     */
    public $user_id = 0;

    /**
     * Post id
     *
     * @var intiger
     * @access public
     */
    public $post_id = 0;

    /**
     * Author data
     *
     * @var array
     * @access public
     */
    public $author = array();

    public function setAuthor($user_id, $post_id = null)
    {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->author = ClassRegistry::init('User')->getUser($this->user_id);
    }

    /**
     * Retrieve the author of the current post or page.
     *
     * @return string The author's display name.
     */
    public function getAuthor()
    {
        $output = $this->getAuthorMeta('display_name');

        return $this->Hook->applyFilters('Helper.Author.getAuthor', $output);
    }

    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @param string $field selects the field of the users record.
     *
     * @return string The author's field from the current author's DB.
     */
    public function getAuthorMeta($field)
    {
        if (array_key_exists($field, $this->author['UserMeta'])) {
            $output = $this->author['UserMeta'][$field];
        } elseif (array_key_exists($field, $this->author['User'])) {
            $output = $this->author['User'][$field];
        } else {
            $output = null;
        }

        return $this->Hook->applyFilters('Helper.Author.getAuthorMeta', $output, $field);
    }

    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @since 0.1.0
     *
     * @param string $field selects the field of the users record.
     *
     * @echo  string The author's field from the current author's DB.
     */
    public function theAuthorMeta($field = '')
    {
        echo $this->Hook->applyFilters('the_author_' . $field, $this->getTheAuthorMeta($field), $this->user_id);
    }

    /**
     * Retrieve the URL to the author page for the user with the ID provided.
     *
     * @param null $authorId
     *
     * @return string The URL to the author's page.
     */
    public function getAuthorPostsUrl($authorId = null)
    {
        if (is_null($authorId)) {
            $authorId = (int)$this->user_id;
        } else {
            $this->author = ClassRegistry::init('User')->getUser($authorId);
        }

        $authorUsername = $this->author['User']['username'];

        $url = $this->Link->siteUrl('/') . 'author/' . $authorUsername;

        return $this->Hook->applyFilters('author_link', $url, $authorId, $authorUsername);
    }

    /**
     * List all the authors of the blog, with several options available.
     *
     * @since 0.1.0
     *
     * @param array $args The argument array.
     *
     * @return null|string The output, if echo is set to false.
     */
    public function getListAuthors($args = array())
    {
        $defaults = [
            'order_by' => 'username',
            'order' => 'ASC',
            'limit' => '',
            'count' => false,
            'exclude_admin' => true,
            'show_fullname' => false,
            'hide_empty' => false,
            'style' => 'list',
            'html' => true
        ];

        $args = Hash::merge($defaults, $args);
        $return = '';

        $queryArgs = HuradFunctions::arraySliceAssoc($args, ['order_by', 'order', 'limit']);
        $authors = ClassRegistry::init('User')->getUsers($queryArgs);

        foreach ($authors as $author) {
            $author = ClassRegistry::init('User')->getUser($author['User']['id']);

            if ($args['exclude_admin'] && 'administrator' == $author['User']['role']) {
                continue;
            }

            $posts = ClassRegistry::init('Post')->countUserPosts($author['User']['id']);

            if (!$posts && $args['hide_empty']) {
                continue;
            }

            if ($args['show_fullname'] && isset($author['UserMeta']['first_name']) && isset($author['UserMeta']['last_name'])) {
                $name = "{$author['UserMeta']['first_name']} {$author['UserMeta']['last_name']}";
            } else {
                $name = $author['UserMeta']['display_name'];
            }

            if (!$args['html']) {
                $return .= $name . ', ';
                continue;
            }

            if ('list' == $args['style']) {
                $return .= '<li>';
            }

            $link = $this->Html->link(
                $name,
                $this->getAuthorPostsUrl($author['User']['id']),
                ['title' => __("Posts by %s", $author['UserMeta']['display_name'])]
            );


            if ($args['count']) {
                $link .= ' (' . $posts . ')';
            }

            $return .= $link;
            $return .= ('list' == $args['style']) ? '</li>' : ', ';
        }

        $return = rtrim($return, ', ');

        return $return;
    }
}
