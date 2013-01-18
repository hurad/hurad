<?php

App::uses('Formatting', 'Lib');

/**
 * Description of CommentHelper
 *
 * @author mohammad
 */
class CommentHelper extends AppHelper {

    /**
     * Current Post
     *
     * @var array
     * @access public
     */
    public $post = array();

    /**
     * Current Page
     *
     * @var array
     * @access public
     */
    public $page = array();

    /**
     * Current Comment
     *
     * @var array
     * @access public
     */
    public $comment = array();

    /**
     * Current User Logged
     *
     * @var array
     * @access public
     */
    public $current_user = array();

    /**
     * Current controller
     *
     * @var string
     * @access public
     */
    public $view_path = null;

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Form', 'Time', 'Text', 'Gravatar', 'Post', 'Page');

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->view_path = $this->_View->viewPath;
        $this->post = $this->_View->getVar('post');
        $this->page = $this->_View->getVar('page');
        $this->current_user = $this->_View->getVar('current_user');
        //debug($this->current_user);
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    /**
     * Retrieve the comment id of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return int The comment ID
     */
    public function get_comment_ID() {
        return $this->comment['id'];
    }

    /**
     * Displays the comment id of the current comment.
     *
     * @since 0.1
     * @see get_comment_ID() Echoes Result
     */
    public function comment_ID() {
        echo $this->get_comment_ID();
    }

    /**
     * Display the comment time of the current comment.
     *
     * @since 0.1
     *
     * @param string $format Optional. The format of the time (defaults to user's config)
     */
    public function comment_time($format) {
        echo $this->get_comment_time($format);
    }

    /**
     * Retrieve the comment time of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @param string $format Optional. The format of the time (defaults to user's config)
     * @return string The formatted time
     */
    public function get_comment_time($format = '') {
        if ('' == $format) {
            $time = $this->Time->format(Configure::read('General-time_format'), $this->comment['created'], null, Configure::read('General-timezone'));
        } else {
            $time = $this->Time->format($format, $this->comment['created'], null, Configure::read('General-timezone'));
        }
        return $time;
    }

    /**
     * Retrieve the comment date of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @param string $format The format of the date (defaults to user's config)
     * @return string The comment's date
     */
    function get_comment_date($format = '') {
        if ('' == $format) {
            $date = $this->Time->format(Configure::read('General-date_format'), $this->comment['created'], null, Configure::read('General-timezone'));
        } else {
            $date = $this->Time->format($format, $this->comment['created'], null, Configure::read('General-timezone'));
        }
        return $date;
    }

    /**
     * Display the comment date of the current comment.
     *
     * @since 0.1
     *
     * @param string $d The format of the date (defaults to user's config)
     * @param int $comment_ID The ID of the comment for which to print the date. Optional.
     */
    public function comment_date($format) {
        echo $this->get_comment_date($format);
    }

    /**
     * Displays the author of the current comment.
     *
     * @since 0.1
     * @uses get_comment_author() Retrieves the comment author
     */
    public function comment_author() {
        echo $this->get_comment_author();
    }

    /**
     * Retrieve the author of the current comment.
     *
     * If the comment has an empty comment_author field, then 'Anonymous' person is
     * assumed.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return string The comment author
     */
    public function get_comment_author() {
        if (empty($this->comment['author'])) {
            $author = __('Anonymous');
        } else {
            $author = $this->comment['author'];
        }
        return $author;
    }

    /**
     * Display the email of the author of the current comment.
     *
     * Care should be taken to protect the email address and assure that email
     * harvesters do not capture your commentors' email address. Most assume that
     * their email address will not appear in raw form on the blog. Doing so will
     * enable anyone, including those that people don't want to get the email
     * address and use it for their own means good and bad.
     *
     * @since 0.1
     * @uses get_comment_author_email() Retrieves the comment author's email.
     */
    public function comment_author_email() {
        echo $this->get_comment_author_email();
    }

    /**
     * Retrieve the email of the author of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return string The current comment author's email
     */
    public function get_comment_author_email() {
        return $this->comment['author_email'];
    }

    /**
     * Display the html email link to the author of the current comment.
     *
     * Care should be taken to protect the email address and assure that email
     * harvesters do not capture your commentors' email address. Most assume that
     * their email address will not appear in raw form on the blog. Doing so will
     * enable anyone, including those that people don't want to get the email
     * address and use it for their own means good and bad.
     *
     * @since 1.0.0
     * @uses get_comment_author_email_link() For generating the link
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    public function comment_author_email_link($linktext = '', $before = '', $after = '') {
        if ($link = $this->get_comment_author_email_link($linktext, $before, $after)) {
            echo $link;
        }
    }

    /**
     * Return the html email link to the author of the current comment.
     *
     * Care should be taken to protect the email address and assure that email
     * harvesters do not capture your commentors' email address. Most assume that
     * their email address will not appear in raw form on the blog. Doing so will
     * enable anyone, including those that people don't want to get the email
     * address and use it for their own means good and bad.
     *
     * @since 1.0.0
     * @uses get_comment_author_email() for the display of the comment author's email
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    public function get_comment_author_email_link($linktext = '', $before = '', $after = '') {
        if ($this->get_comment_author_email()) {
            if ($linktext != '') {
                $display = $linktext;
            } else {
                $display = $this->get_comment_author_email();
            }
            $return = $before;
            $return .= $this->Html->link($display, 'mailto:' . $this->get_comment_author_email());
            $return .= $after;
            return $return;
        } else {
            return '';
        }
    }

    /**
     * Display the IP address of the author of the current comment.
     *
     * @since 0.1
     * @see get_comment_author_IP() Echoes Result
     */
    public function comment_author_IP() {
        echo $this->get_comment_author_IP();
    }

    /**
     * Retrieve the IP address of the author of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return string The comment author's IP address.
     */
    public function get_comment_author_IP() {
        return $this->comment['author_ip'];
    }

    /**
     * Display the url of the author of the current comment.
     *
     * @since 0.1
     * @uses get_comment_author_url() Retrieves the comment author's URL
     */
    public function comment_author_url() {
        echo $this->get_comment_author_url();
    }

    /**
     * Retrieve the url of the author of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return string
     */
    public function get_comment_author_url() {
        return $this->comment['author_url'];
    }

    /**
     * Retrieves the HTML link of the url of the author of the current comment.
     *
     * $linktext parameter is only used if the URL does not exist for the comment
     * author. If the URL does exist then the URL will be used and the $linktext
     * will be ignored.
     *
     * Encapsulate the HTML link between the $before and $after. So it will appear
     * in the order of $before, link, and finally $after.
     *
     * @since 0.1
     * @uses get_comment_author_url
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     * @return string The HTML link between the $before and $after parameters
     */
    function get_comment_author_url_link($linktext = '', $before = '', $after = '') {
        $url = $this->get_comment_author_url();
        $display = ($linktext != '') ? $linktext : $url;
        $display = str_replace('http://www.', '', $display);
        $display = str_replace('http://', '', $display);
        if ('/' == substr($display, -1))
            $display = substr($display, 0, -1);
        $return = $before . $this->Html->link($display, $url, array('rel' => 'external')) . $after;
        return $return;
    }

    /**
     * Displays the HTML link of the url of the author of the current comment.
     *
     * @since 0.1
     * @see get_comment_author_url_link() Echoes result
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    function comment_author_url_link($linktext = '', $before = '', $after = '') {
        echo $this->get_comment_author_url_link($linktext, $before, $after);
    }

    /**
     * Generates semantic classes for each comment element
     *
     * @since 1.0.0
     *
     * @param string|array $class One or more classes to add to the class list
     * @param bool $echo Whether comment_class should echo or return
     */
    function comment_class($class = '', $echo = true) {
        // Separates classes with a single space, collates classes for comment DIV
        $class = 'class="' . join(' ', $this->get_comment_class($class)) . '"';
        if ($echo)
            echo $class;
        else
            return $class;
    }

    /**
     * Returns the classes for the comment div as an array
     *
     * @since 1.0.0
     *
     * @param string|array $class One or more classes to add to the class list
     * @return array Array of classes
     */
    function get_comment_class($class = '') {
        global $comment_alt, $comment_depth, $comment_thread_alt;

        $classes = array();

        // Comment type,
        $classes[] = 'comment';

        // If the comment author has an id (registered), then print the log in name
        if ($this->comment['user_id'] > 0 && $user = ClassRegistry::init('User')->get_userdata($this->comment['user_id'])) {
            // For all registered users, 'byuser'
            $classes[] = 'byuser';
            $classes[] = 'comment-author-' . Formatting::sanitize_html_class($user['User']['nickname'], $this->comment['user_id']);
            // For comment authors who are the author of the post
            if ($post = ClassRegistry::init('Post')->get_post($this->comment['post_id'])) {
                if ($this->comment['user_id'] === $post['Post']['user_id'])
                    $classes[] = 'bypostauthor';
            }
        }

        if (empty($comment_alt))
            $comment_alt = 0;
        if (empty($comment_depth))
            $comment_depth = 1;
        if (empty($comment_thread_alt))
            $comment_thread_alt = 0;

        if ($comment_alt % 2) {
            $classes[] = 'odd';
            $classes[] = 'alt';
        } else {
            $classes[] = 'even';
        }

        $comment_alt++;

        // Alt for top-level comments
        if (1 == $comment_depth) {
            if ($comment_thread_alt % 2) {
                $classes[] = 'thread-odd';
                $classes[] = 'thread-alt';
            } else {
                $classes[] = 'thread-even';
            }
            $comment_thread_alt++;
        }

        $classes[] = "depth-$comment_depth";

        if (!empty($class)) {
            if (!is_array($class))
                $class = preg_split('#\s+#', $class);
            $classes = array_merge($classes, $class);
        }

        $classes = array_map('Formatting::esc_attr', $classes);
//debug($classes);
        return $classes;
    }

    /**
     * The status of a comment.
     *
     * @since 1.0.0
     *
     * @param int $approved Comment Status
     * @return string|bool Status might be 'trash', 'approved', 'unapproved', 'spam'. False on failure.
     */
    function get_comment_status($approved) {
        if ($approved == null)
            return false;
        elseif ($approved == '1')
            return 'approved';
        elseif ($approved == '0')
            return 'unapproved';
        elseif ($approved == 'spam')
            return 'spam';
        elseif ($approved == 'trash')
            return 'trash';
        else
            return false;
    }

    /**
     * Retrieve the excerpt of the current comment.
     *
     * Will cut each word and only output the first 20 words with '...' at the end.
     * If the word count is less than 20, then no truncating is done and no '...'
     * will appear.
     *
     * @since 1.0.0
     *
     * @return string The maybe truncated comment with 20 words or less
     */
    public function get_comment_excerpt() {
        $comment_text = strip_tags($this->comment['content']);
        $blah = explode(' ', $comment_text);
        if (count($blah) > 20) {
            $use_dotdotdot = 1;
        } else {
            $use_dotdotdot = 0;
        }
        if ($use_dotdotdot) {
            return $this->Text->truncate($this->comment['content'], 20);
        } else {
            return $this->comment['content'];
        }
    }

    /**
     * Display the excerpt of the current comment.
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function comment_excerpt() {
        echo $this->get_comment_excerpt();
    }

    /**
     * Retrieves the link to the current post comments.
     *
     * @since 1.0.0
     *
     * @return string The link to the comments
     */
    public function get_comments_link() {
        return $this->Post->get_permalink() . '#comments';
    }

    /**
     * Displays the link to the current post comments.
     *
     * @since 1.0.0
     * @see get_comments_link() Echoes Result
     *
     */
    function comments_link() {
        echo $this->get_comments_link();
    }

    /**
     * Retrieve the amount of comments a post has.
     *
     * @since 1.0.0
     * @uses $post
     *
     * @return int The number of comments a post has
     */
    function get_comments_number() {
        if ($this->view_path == 'Posts') {
            return $this->Post->post['Post']['comment_count'];
        } elseif ($this->view_path == 'Pages') {
            return $this->Page->page['Page']['comment_count'];
        }
    }

    /**
     * Display the language string for the number of comments the current post has.
     *
     * @since 0.1
     * @uses get_comments_number()
     *
     * @param string $zero Text for no comments
     * @param string $one Text for one comment
     * @param string $more Text for more than one comment
     */
    function comments_number($zero = false, $one = false, $more = false) {

        $number = $this->get_comments_number();

        if ($number > 1) {
            $output = str_replace('%', $number, ( false === $more ) ? __('% Comments') : $more);
        } elseif ($number == 0) {
            $output = ( false === $zero ) ? __('No Comments') : $zero;
        } else {// must be one
            $output = ( false === $one ) ? __('1 Comment') : $one;
        }
        echo $output;
    }

    /**
     * Retrieve the text of the current comment.
     *
     * @since 0.1
     * @uses $comment
     *
     * @return string The comment content
     */
    public function get_comment_text() {
        return $this->comment['content'];
    }

    /**
     * Displays the text of the current comment.
     *
     * @since 0.1
     * @uses get_comment_text() Gets the comment content
     *
     */
    public function comment_text() {
        echo $this->get_comment_text();
    }

    /**
     * Whether the current post is open for comments.
     *
     * @since 0.1
     * @uses $post
     *
     * @return bool True if the comments are open
     */
    function comments_open() {
        if ($this->view_path == 'Posts') {
            $open = ( 'open' == $this->post['Post']['comment_status'] );
            return $open;
        } elseif ($this->view_path == 'Pages') {
            $open = ( 'open' == $this->page['Page']['comment_status'] );
            return $open;
        }
    }

    /**
     * Displays the link to the comments popup window for the current post ID.
     *
     * Is not meant to be displayed on single posts and pages. Should be used on the
     * lists of posts
     *
     * @since 0.1
     * @uses $post
     *
     * @param string $zero The string to display when no comments
     * @param string $one The string to display when only one comment is available
     * @param string $more The string to display when there are more than one comment
     * @param string $css_class The CSS class to use for comments
     * @param string $none The string to display when comments have been turned off
     * @return null Returns null on single posts and pages.
     */
    function comments_popup_link($zero = false, $one = false, $more = false, $css_class = '', $none = false) {

        if (false === $zero)
            $zero = __('No Comments');
        if (false === $one)
            $one = __('1 Comment');
        if (false === $more)
            $more = __('% Comments');
        if (false === $none)
            $none = __('Comments Off');

        $number = $this->get_comments_number();

        if (0 == $number && $this->comments_open()) {
            echo '<span' . ((!empty($css_class)) ? ' class="' . $css_class . '"' : '') . '>' . $none . '</span>';
            return;
        }

        echo '<a href="';

        if (0 == $number) {
            if ($this->view_path == 'Posts') {
                echo $this->Post->get_permalink() . '#respond';
            } elseif ($this->view_path == 'Pages') {
                echo $this->Page->get_permalink() . '#respond';
            }
            echo '"';
        } else {
            $this->comments_link();
            echo '"';
        }

        if (!empty($css_class)) {
            echo ' class="' . $css_class . '" ';
        }
        if ($this->view_path == 'Posts') {
            $title = $this->Post->the_title_attribute(array('echo' => 0));
        } elseif ($this->view_path == 'Pages') {
            $title = $this->Page->the_title_attribute(array('echo' => 0));
        }

        echo ' title="' . sprintf(__('Comment on %s'), $title) . '">';
        $this->comments_number($zero, $one, $more);
        echo '</a>';
    }

    public function comments_template() {
        if ($this->comments_open()) {
            $this->_comment_list();
            if ($this->current_user) {
                $this->_loggedin_comment_form();
            } else {
                $this->_loggedout_comment_form();
            }
        } else {
            echo __('Comment Closed');
        }
    }

    protected function _loggedin_comment_form() {
        echo '<div id="respond">';
        echo '<h3 id="reply-title">' . __('Leave a Reply') . '</h3>';

        echo $this->Form->create('Comment', array(
            'action' => 'add',
            'id' => 'commentform',
            'inputDefaults' => array(
                'label' => false,
                'div' => false
            )
        ));

        echo '<p class="logged-in-as">';
        echo __('Logged in as %s. ', $this->Html->link($this->current_user['username'], array('admin' => TRUE, 'controller' => 'users', 'action' => 'profile', $this->current_user['id'])));
        echo $this->Html->link(__('Log out?'), '/logout', array('title' => __('Log out of this account')));
        echo '</p>';

        echo '<p>';
        echo $this->Form->input('content', array('tabindex' => '4', 'rows' => '10', 'cols' => '74%'));
        echo '</p>';

        echo '<p style = "display: none;">';
        echo $this->Form->input('author', array('type' => 'hidden', 'value' => $this->current_user['username']));
        echo $this->Form->input('author_email', array('type' => 'hidden', 'value' => $this->current_user['email']));
        echo $this->Form->input('author_url', array('type' => 'hidden', 'value' => $this->current_user['url']));
        echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $this->post['Post']['id']));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->current_user['id']));
        echo '</p>';

        echo '<p>';
        echo $this->Form->end(array('label' => __('Post Comment'), 'div' => FALSE, 'tabindex' => '5'));
        echo '</p>';

        echo '<div style = "clear: both;"></div>';
        echo '</div>';
    }

    protected function _loggedout_comment_form() {
        echo '<div id="respond">';
        echo '<h3 id="reply-title">' . __('Leave a Reply') . '</h3>';

        echo $this->Form->create('Comment', array(
            'action' => 'add',
            'id' => 'commentform',
            'inputDefaults' => array(
                'label' => false,
                'div' => false
            )
        ));
        echo '<p>';
        echo $this->Form->input('author', array('tabindex' => '1', 'size' => '22'));
        echo '<label for="CommentAuthor">';
        echo '<small>' . __('Name (Required)') . '</small>';
        echo '</label>';
        echo '</p>';

        echo '<p>';
        echo $this->Form->input('author_email', array('tabindex' => '2', 'size' => '22'));
        echo '<label for="CommentAuthorEmail">';
        echo '<small>' . __('eMail (Required)') . '</small>';
        echo '</label>';
        echo '</p>';

        echo '<p>';
        echo $this->Form->input('author_url', array('tabindex' => '3', 'size' => '22'));
        echo '<label for="CommentAuthorUrl">';
        echo '<small>' . __('URL') . '</small>';
        echo '</label>';
        echo '</p>';

        echo '<p>';
        echo $this->Form->input('content', array('tabindex' => '4', 'rows' => '10', 'cols' => '74%'));
        echo '</p>';

        echo '<p style = "display: none;">';
        echo $this->Form->input('post_id', array('type' => 'hidden', 'value' => $this->post['Post']['id']));
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => '0'));
        echo '</p>';

        echo '<p>';
        echo $this->Form->end(array('label' => __('Post Comment'), 'div' => FALSE, 'tabindex' => '5'));
        echo '</p>';

        echo '<div style = "clear: both;"></div>';
        echo '</div>';
    }

    protected function _comment_list() {
        if ($this->view_path == 'Posts') {
            $comments = $this->post['Comment'];
        } elseif ($this->view_path == 'Pages') {
            $comments = $this->page['Comment'];
        }
        echo '<h4 class = "comment-title">' . $this->post['Post']['comment_count'] . ' Comment</h4>';
        echo '<ol class = "commentlist">';
        foreach ($comments as $comment) {
            $this->setComment($comment);
            echo '<li id = "comment-' . $this->get_comment_ID() . '" class = "comment even thread-even depth-1">';
            echo '<p class = "comment-author">';
            echo $this->Gravatar->image($this->get_comment_author_email(), array('size' => '48', 'default' => 'mm'));
            echo '<cite>';
            echo $this->get_comment_author_url_link($this->get_comment_author());
            echo '</cite>';
            echo '<br>';
            echo '<small class = "comment-time">';
            echo '<strong>' . $this->get_comment_date() . '</strong>';
            echo ' @ ' . $this->get_comment_time();
            echo '</small>';
            echo '</p>';
            echo '<div class = "commententry">';
            echo $this->get_comment_text();
            echo '</div>';
            echo '<p class="reply"> </p>';
            echo '</li>';
        }

        echo '</ol>';
    }

}