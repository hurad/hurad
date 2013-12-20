<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of AuthorHelper
 *
 * @author mohammad
 */
class AuthorHelper extends AppHelper
{

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Hook', 'Html', 'Link');

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
    public $authorData = array();

    public function setAuthor($user_id, $post_id = null)
    {
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->authorData = ClassRegistry::init('User')->getUserData($this->user_id);
    }

    /**
     * Retrieve the author of the current post.
     *
     * @since 0.1.0
     * @uses apply_filters() Calls 'the_author' hook on the author display name.
     * @link https://github.com/hurad/hurad/wiki/get_the_author
     *
     * @return string The author's display name.
     */
    public function getTheAuthor()
    {
        return $this->Hook->applyFilters(
            'the_author',
            is_array($this->authorData) ? $this->authorData['display_name'] : null
        );
    }

    /**
     * Display the name of the author of the current post.
     *
     * @since 0.1.0
     * @see get_the_author()
     * @link https://github.com/hurad/hurad/wiki/the_author
     *
     * @return string The author's display name, from get_the_author().
     */
    public function theAuthor()
    {
        echo $this->getTheAuthor();
    }

    /**
     * Retrieve the author who last edited the current post.
     *
     * @since 0.1.0
     * @uses getPostMeta() Retrieves the ID of the author who last edited the current post.
     * @uses apply_filters() Calls 'the_modified_author' hook on the author display name.
     * @link https://github.com/hurad/hurad/wiki/get_the_modified_author
     *
     * @return string The author's display name.
     */
    public function getTheModifiedAuthor()
    {
        if ($last_id = ClassRegistry::init('PostMeta')->getPostMeta($this->post_id, '_edit_last')) {
            $last_user = ClassRegistry::init('User')->getUserData($last_id['PostMeta']['meta_value']);
            return $this->Hook->applyFilters('the_modified_author', $last_user['display_name']);
        }
    }

    /**
     * Display the name of the author who last edited the current post.
     *
     * @since 0.1.0
     * @see get_the_author()
     * @return string The author's display name, from get_the_modified_author().
     */
    public function theModifiedAuthor()
    {
        echo $this->getTheModifiedAuthor();
    }

    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @since 0.1.0
     *
     * @param string $field selects the field of the users record.
     *
     * @return string The author's field from the current author's DB.
     */
    public function getTheAuthorMeta($field = '')
    {
        if (in_array(
            $field,
            array('username', 'password', 'nicename', 'email', 'url', 'created', 'activation_key', 'status')
        )
        ) {
            $field = $field;
        }

        $value = isset($this->authorData[$field]) ? $this->authorData[$field] : '';

        return $this->Hook->applyFilters('get_the_author_' . $field, $value, $this->user_id);
    }

    /**
     * Retrieve the requested data of the author of the current post.
     *
     * @since 0.1.0
     *
     * @param string $field selects the field of the users record.
     *
     * @echo string The author's field from the current author's DB.
     */
    public function theAuthorMeta($field = '')
    {
        echo $this->Hook->applyFilters('the_author_' . $field, $this->getTheAuthorMeta($field), $this->user_id);
    }

    /**
     * Retrieve either author's link or author's name.
     *
     * If the author has a home page set, return an HTML link, otherwise just return the
     * author's name.
     *
     * @since 0.1.0
     *
     * @uses get_the_author_meta()
     * @uses get_the_author()
     */
    public function getTheAuthorLink()
    {
        if ($this->getTheAuthorMeta('url')) {
            return $this->Html->link(
                $this->getTheAuthor(),
                HuradSanitize::url($this->getTheAuthorMeta('url')),
                array('title' => __("Visit %s&#8217;s website", $this->getTheAuthor()), 'rel' => 'author external')
            );
        } else {
            return $this->getTheAuthor();
        }
    }

    /**
     * Display either author's link or author's name.
     *
     * If the author has a home page set, echo an HTML link, otherwise just echo the
     * author's name.
     *
     * @since 0.1.0
     * @uses get_the_author_link()
     */
    public function theAuthorLink()
    {
        echo $this->getTheAuthorLink();
    }

    /**
     * Retrieve the number of posts by the author of the current post.
     *
     * @since 0.1.0
     *
     * @uses countUserPosts()
     * @return int The number of posts by the author.
     */
    public function getTheAuthorPosts()
    {
        return ClassRegistry::init('Post')->countUserPosts($this->user_id);
    }

    /**
     * Display the number of posts by the author of the current post.
     *
     * @since 0.1.0
     *
     * @uses get_the_author_posts() Echoes returned value from function.
     */
    public function theAuthorPosts()
    {
        echo $this->getTheAuthorPosts();
    }

    /**
     * Retrieve the URL to the author page for the user with the ID provided.
     *
     * @since 0.1.0
     *
     * @param intiger $author_id
     *
     * @return string The URL to the author's page.
     */
    public function getAuthorPostsUrl($author_id = null)
    {
        if (is_null($author_id)) {
            $author_id = (int)$this->user_id;
        } else {
            $this->authorData = ClassRegistry::init('User')->getUserData($author_id);
        }

        $author_username = $this->authorData['username'];

        $siteUrl = $this->Link->siteUrl('/');
        $link = $siteUrl . 'author/' . $author_username;

        return $this->Hook->applyFilters('author_link', $link, $author_id, $author_username);
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
            $author = ClassRegistry::init('User')->getUserData($author['User']['id']);

            if ($args['exclude_admin'] && 'administrator' == $author['role']) {
                continue;
            }

            $posts = ClassRegistry::init('Post')->countUserPosts($author['id']);

            if (!$posts && $args['hide_empty']) {
                continue;
            }

            if ($args['show_fullname'] && isset($author['firstname']) && isset($author['lastname'])) {
                $name = "{$author['firstname']} {$author['lastname']}";
            } else {
                $name = $author['display_name'];
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
                $this->getAuthorPostsUrl($author['id'], $author['nicename']),
                ['title' => __("Posts by %s", $author['display_name'])]
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
