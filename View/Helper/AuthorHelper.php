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
     * @param string $author_nickname Description
     *
     * @return string The URL to the author's page.
     */
    public function getAuthorPostsUrl($author_id = null, $author_nickname = '')
    {
        if (is_null($author_id)) {
            $author_id = (int)$this->user_id;
        } else {
            $this->authorData = ClassRegistry::init('User')->getUserData($author_id);
        }

        if ('' == $author_nickname) {
            if (!empty($this->authorData['nickname'])) {
                $author_nickname = $this->authorData['nickname'];
            }
        }
        $file = $this->Link->siteUrl('/');
        $link = $file . 'author/' . $author_nickname;

        $link = $this->Hook->applyFilters('author_link', $link, $author_id, $author_nickname);

        return $link;
    }

    /**
     * List all the authors of the blog, with several options available.
     * <code>
     * <ul>
     * <li>optioncount (boolean) (false): Show the count in parenthesis next to the
     * author's name.</li>
     * <li>exclude_admin (boolean) (true): Exclude the 'admin' user that is
     * installed by default.</li>
     * <li>show_fullname (boolean) (false): Show their full names.</li>
     * <li>hide_empty (boolean) (true): Don't show authors without any posts.</li>
     * <li>feed (string) (''): If isn't empty, show links to author's feeds.</li>
     * <li>feed_image (string) (''): If isn't empty, use this image to link to
     * feeds.</li>
     * <li>echo (boolean) (true): Set to false to return the output, instead of
     * echoing.</li>
     * <li>style (string) ('list'): Whether to display list of authors in list form
     * or as a string.</li>
     * <li>html (bool) (true): Whether to list the items in html form or plaintext.
     * </li>
     * </ul>
     * </code>
     *
     * @since 0.1.0
     *
     * @param array $args The argument array.
     *
     * @return null|string The output, if echo is set to false.
     */
    public function hrListAuthors($args = '')
    {
        //global $wpdb;

        $defaults = array(
            'orderby' => 'username',
            'order' => 'ASC',
            'number' => '',
            'optioncount' => false,
            'exclude_admin' => true,
            'show_fullname' => false,
            'hide_empty' => true,
            'feed' => '',
            'feed_image' => '',
            'feed_type' => '',
            'echo' => true,
            'style' => 'list',
            'html' => true
        );

        $args = Hash::merge($defaults, $args);
        extract($args, EXTR_SKIP);

        $return = '';

        $query_args = HuradFunctions::arraySliceAssoc($args, array('orderby', 'order', 'number'));
        //$query_args['fields'] = 'ids';
        $authors = ClassRegistry::init('User')->getUsers($query_args);

//        $author_count = array();
//        foreach ((array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql('post') . " GROUP BY post_author") as $row)
//            $author_count[$row->post_author] = $row->count;

        foreach ($authors as $key => $author) {
            $author = ClassRegistry::init('User')->getUserData($author['User']['id']);

            if ($exclude_admin && 'admin' == $author['display_name']) {
                continue;
            }

            //$posts = isset($author_count[$author->ID]) ? $author_count[$author->ID] : 0;
            $posts = ClassRegistry::init('Post')->countUserPosts($author['id']);


            if (!$posts && $hide_empty) {
                continue;
            }

            $link = '';

            if ($show_fullname && $author['firstname'] && $author['lastname']) {
                $name = "{$author['firstname']} {$author['lastname']}";
            } else {
                $name = $author['display_name'];
            }

            if (!$html) {
                $return .= $name . ', ';

                continue; // No need to go further to process HTML.
            }

            if ('list' == $style) {
                $return .= '<li>';
            }

            //$link = '<a href="' . get_author_posts_url($author->ID, $author->user_nicename) . '" title="' . esc_attr(sprintf(__("Posts by %s"), $author->display_name)) . '">' . $name . '</a>';
            $link = $this->Html->link(
                $name,
                $this->getAuthorPostsUrl($author['id'], $author['nicename']),
                array('title' => __("Posts by %s", $author['display_name']))
            );

//            if (!empty($feed_image) || !empty($feed)) {
//                $link .= ' ';
//                if (empty($feed_image)) {
//                    $link .= '(';
//                }
//
//                $link .= '<a href="' . get_author_feed_link($author->ID) . '"';
//
//                $alt = $title = '';
//                if (!empty($feed)) {
//                    $title = ' title="' . esc_attr($feed) . '"';
//                    $alt = ' alt="' . esc_attr($feed) . '"';
//                    $name = $feed;
//                    $link .= $title;
//                }
//
//                $link .= '>';
//
//                if (!empty($feed_image))
//                    $link .= '<img src="' . esc_url($feed_image) . '" style="border: none;"' . $alt . $title . ' />';
//                else
//                    $link .= $name;
//
//                $link .= '</a>';
//
//                if (empty($feed_image))
//                    $link .= ')';
//            }

            if ($optioncount) {
                $link .= ' (' . $posts . ')';
            }

            $return .= $link;
            $return .= ('list' == $style) ? '</li>' : ', ';
        }

        $return = rtrim($return, ', ');

        if (!$echo) {
            return $return;
        }

        echo $return;
    }

}