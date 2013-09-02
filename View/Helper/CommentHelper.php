<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of CommentHelper
 *
 * @author mohammad
 */
class CommentHelper extends AppHelper
{

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
     * User model object
     *
     * @var object
     * @access public
     */
    public $MUser = null;

    /**
     * Post model object
     *
     * @var object
     * @access public
     */
    public $MPost = null;

    /**
     * Comment alt count
     *
     * @var object
     * @access public
     */
    public $comment_alt = null;

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Hook', 'Html', 'Form', 'Time', 'Text', 'Gravatar', 'Post', 'Page', 'Link');

    public function __construct(View $View, $settings = array())
    {
        parent::__construct($View, $settings);
        $this->view_path = $this->_View->viewPath;
        $this->post = $this->Link->post = $this->_View->getVar('post');
        $this->page = $this->_View->getVar('page');
        $this->current_user = $this->_View->getVar('current_user');
        $this->MUser = & ClassRegistry::getObject('User');
        $this->MPost = & ClassRegistry::getObject('Post');
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Retrieve the author of the current comment.
     *
     * If the comment has an empty comment_author field, then 'Anonymous' person is
     * assumed.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'getCommentAuthor' hook on the comment author
     *
     * @return string The comment author
     */
    public function getCommentAuthor()
    {
        if (empty($this->comment['author'])) {
            if (!empty($this->comment['user_id'])) {
                $user = $this->MUser->getUserData($this->comment['user_id']);
                $author = $user['username'];
            } else {
                $author = __('Anonymous');
            }
        } else {
            $author = $this->comment['author'];
        }
        return $this->Hook->applyFilters('getCommentAuthor', $author);
    }

    /**
     * Displays the author of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'commentAuthor' on comment author before displaying
     */
    public function commentAuthor()
    {
        $author = $this->Hook->applyFilters('commentAuthor', $this->getCommentAuthor());
        echo $author;
    }

    /**
     * Retrieve the email of the author of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls the 'getCommentAuthorEmail' hook on the comment author email
     *
     * @return string The current comment author's email
     */
    public function getCommentAuthorEmail()
    {
        return $this->Hook->applyFilters('getCommentAuthorEmail', $this->comment['author_email']);
    }

    /**
     * Display the email of the author.
     *
     * Care should be taken to protect the email address and assure that email
     * harvesters do not capture your commentors' email address. Most assume that
     * their email address will not appear in raw form on the blog. Doing so will
     * enable anyone, including those that people don't want to get the email
     * address and use it for their own means good and bad.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'commentAuthorEmail' hook on the author email
     */
    public function commentAuthorEmail()
    {
        echo $this->Hook->applyFilters('commentAuthorEmail', $this->getCommentAuthorEmail());
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
     * @since 0.1.0
     * @uses applyFilters() Calls 'author_email' hook for the display of the comment author's email
     * @uses getCommentAuthorEmailLink() For generating the link
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    public function commentAuthorEmailLink($linktext = '', $before = '', $after = '')
    {
        if ($link = $this->getCommentAuthorEmailLink($linktext, $before, $after)) {
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
     * @since 0.1.0
     * @uses applyFilters() Calls 'author_email' hook for the display of the comment author's email
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    public function getCommentAuthorEmailLink($linktext = '', $before = '', $after = '')
    {
        $email = $this->Hook->applyFilters('author_email', $this->comment['author_email']);
        if ((!empty($email)) && ($email != '@')) {
            $display = ($linktext != '') ? $linktext : $email;
            $return = $before;
            $return .= $this->Html->link($display, 'mailto:' . $email);
            $return .= $after;
            return $return;
        } else {
            return '';
        }
    }

    /**
     * Retrieve the html link to the url of the author of the current comment.
     *
     * @since 0.1.0
     * @uses getCommentAuthorUrl() For retrieve the url of the author of the current comment.
     * @uses getCommentAuthor() For retrieve the author of the current comment.
     * @uses applyFilters() Calls 'getCommentAuthorLink' hook on the complete link HTML or author
     *
     * @return string Comment Author name or HTML link for author's URL
     */
    public function getCommentAuthorLink()
    {
        $url = $this->getCommentAuthorUrl();
        $author = $this->getCommentAuthor();

        if (empty($url) || 'http://' == $url) {
            $return = $author;
        } else {
            $return = $this->Html->link('Enter', $url, array('class' => 'url', 'rel' => 'external nofollow'));
        }
        return $this->Hook->applyFilters('getCommentAuthorLink', $return);
    }

    /**
     * Display the html link to the url of the author of the current comment.
     *
     * @since 0.1.0
     * @see getCommentAuthorLink() Echoes result
     */
    public function commentAuthorLink()
    {
        echo $this->getCommentAuthorLink();
    }

    /**
     * Retrieve the IP address of the author of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters()
     *
     * @return string The comment author's IP address.
     */
    public function getCommentAuthorIP()
    {
        return $this->Hook->applyFilters('getCommentAuthorIP', $this->comment['author_ip']);
    }

    /**
     * Display the IP address of the author of the current comment.
     *
     * @since 0.1.0
     * @see getCommentAuthorIP() Echoes Result
     */
    public function commentAuthorIP()
    {
        echo $this->getCommentAuthorIP();
    }

    /**
     * Retrieve the url of the author of the current comment.
     *
     * @since 0.1.0
     * @uses apply_filters() Calls 'getCommentAuthorUrl' hook on the comment author's URL
     *
     * @return string
     */
    public function getCommentAuthorUrl()
    {
        $url = ('http://' == $this->comment['author_url']) ? '' : $this->comment['author_url'];
        $url = Formatting::esc_url($url, array('http', 'https'));
        return $this->Hook->applyFilters('getCommentAuthorUrl', $url);
    }

    /**
     * Display the url of the author of the current comment.
     *
     * @since 0.1.0
     * @uses apply_filters()
     * @uses getCommentAuthorUrl() Retrieves the comment author's URL
     */
    public function commentAuthorUrl()
    {
        echo $this->Hook->applyFilters('commentAuthorUrl', $this->getCommentAuthorUrl());
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
     * @since 0.1.0
     * @uses applyFilters() Calls the 'getCommentAuthorUrlLink' on the complete HTML before returning.
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     *
     * @return string The HTML link between the $before and $after parameters
     */
    public function getCommentAuthorUrlLink($linktext = '', $before = '', $after = '')
    {
        $url = $this->getCommentAuthorUrl();
        $display = ($linktext != '') ? $linktext : $url;
        $display = str_replace('http://www.', '', $display);
        $display = str_replace('http://', '', $display);
        if ('/' == substr($display, -1)) {
            $display = substr($display, 0, -1);
        }
        $return = $before . $this->Html->link($display, $url, array('rel' => 'external')) . $after;
        return $this->Hook->applyFilters('getCommentAuthorUrlLink', $return);
    }

    /**
     * Displays the HTML link of the url of the author of the current comment.
     *
     * @since 0.1.0
     * @see getCommentAuthorUrlLink() Echoes result
     *
     * @param string $linktext The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     */
    public function commentAuthorUrlLink($linktext = '', $before = '', $after = '')
    {
        echo $this->getCommentAuthorUrlLink($linktext, $before, $after);
    }

    /**
     * Generates semantic classes for each comment element
     *
     * @since 0.1.0
     *
     * @param string|array $class One or more classes to add to the class list
     * @param bool $echo Whether commentClass should echo or return
     */
    public function commentClass($class = '', $echo = true)
    {
        // Separates classes with a single space, collates classes for comment DIV
        $class = 'class="' . join(' ', $this->getCommentClass($class)) . '"';
        if ($echo) {
            echo $class;
        } else {
            return $class;
        }
    }

    /**
     * Returns the classes for the comment div as an array
     *
     * @since 0.1.0
     *
     * @param string|array $class One or more classes to add to the class list
     *
     * @return array Array of classes
     */
    public function getCommentClass($class = '')
    {
        $classes = array();

        // Get the comment type (comment, trackback),
        $classes[] = 'comment';

        // If the comment author has an id (registered), then print the log in name
        if ($this->comment['user_id'] > 0 && $user = $this->MUser->getUserData($this->comment['user_id'])) {
            // For all registered users, 'byuser'
            $classes[] = 'byuser';
            $classes[] = 'comment-author-' . Formatting::sanitize_html_class(
                    $user['nickname'],
                    $this->comment['user_id']
                );
            // For comment authors who are the author of the post
            if ($post = $this->MPost->getPost($this->comment['post_id'])) {
                if ($this->comment['user_id'] === $post['Post']['user_id']) {
                    $classes[] = 'bypostauthor';
                }
            }
        }

        if (empty($this->comment_alt)) {
            $this->comment_alt = 0;
        }
        if (empty($comment_depth)) {
            $comment_depth = 1;
        }
        if (empty($comment_thread_alt)) {
            $comment_thread_alt = 0;
        }

        if ($this->comment_alt % 2) {
            $classes[] = 'odd';
            $classes[] = 'alt';
        } else {
            $classes[] = 'even';
        }

        $this->comment_alt++;

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
            if (!is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = array_merge($classes, $class);
        }

        $classes = array_map('Formatting::esc_attr', $classes);

        return $this->Hook->applyFilters('getCommentClass', $classes, $class);
    }

    /**
     * Retrieve the comment date of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'getCommentDate' hook with the formatted date and the $d parameter respectively
     * @uses $comment
     *
     * @param string $d The format of the date (defaults to user's config)
     *
     * @return string The comment's date
     */
    public function getCommentDate($d = '')
    {
        if ('' == $d) {
            $date = $this->Time->format(
                Configure::read('General-date_format'),
                $this->comment['created'],
                null,
                Configure::read('General-timezone')
            );
        } else {
            $date = $this->Time->format($d, $this->comment['created'], null, Configure::read('General-timezone'));
        }
        return $this->Hook->applyFilters('getCommentDate', $date, $d);
    }

    /**
     * Display the comment date of the current comment.
     *
     * @since 0.1.0
     *
     * @param string $d The format of the date (defaults to user's config)
     */
    public function commentDate($d = '')
    {
        echo $this->getCommentDate($d);
    }

    /**
     * Retrieve the excerpt of the current comment.
     *
     * Will cut each word and only output the first 20 words with '...' at the end.
     * If the word count is less than 20, then no truncating is done and no '...'
     * will appear.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'getCommentExcerpt' on truncated comment
     *
     * @return string The maybe truncated comment with 20 words or less
     */
    public function getCommentExcerpt()
    {
        $comment_text = strip_tags($this->comment['content']);
        $blah = explode(' ', $comment_text);
        if (count($blah) > 20) {
            $k = 20;
            $use_dotdotdot = 1;
        } else {
            $k = count($blah);
            $use_dotdotdot = 0;
        }
        $excerpt = '';
        for ($i = 0; $i < $k; $i++) {
            $excerpt .= $blah[$i] . ' ';
        }
        $excerpt .= ($use_dotdotdot) ? '...' : '';
        return $this->Hook->applyFilters('getCommentExcerpt', $excerpt);
    }

    /**
     * Display the excerpt of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls 'commentExcerpt' hook before displaying excerpt
     */
    public function commentExcerpt()
    {
        echo $this->Hook->applyFilters('commentExcerpt', $this->getCommentExcerpt());
    }

    /**
     * Retrieve the comment id of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls the 'getCommentID' hook for the comment ID
     *
     * @return int The comment ID
     */
    public function getCommentID()
    {
        return $this->Hook->applyFilters('getCommentID', $this->comment['id']);
    }

    /**
     * Displays the comment id of the current comment.
     *
     * @since 0.1.0
     * @see get_comment_ID() Echoes Result
     */
    public function commentID()
    {
        echo $this->getCommentID();
    }

    /**
     * Retrieves the link to the current post comments.
     *
     * @since 0.1.0
     *
     * @return string The link to the comments
     */
    public function getCommentsLink()
    {
        return $this->Post->getPermalink() . '#comments';
    }

    /**
     * Displays the link to the current post comments.
     *
     * @since 0.1.0
     * @see getCommentsLink() Echoes Result
     *
     */
    public function commentsLink()
    {
        echo $this->getCommentsLink();
    }

    /**
     * Retrieve the amount of comments a post has.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls the 'getCommentsNumber' hook on the number of comments
     *
     * @return int The number of comments a post has
     */
    public function getCommentsNumber()
    {
        if ($this->view_path == 'Posts') {
            $comment_count = $this->Post->post['Post']['comment_count'];
            $post_id = $this->Post->post['Post']['id'];
        } elseif ($this->view_path == 'Pages') {
            $comment_count = $this->Page->page['Page']['comment_count'];
            $post_id = $this->Page->page['Page']['id'];
        }
        if (!isset($comment_count)) {
            $count = 0;
        } else {
            $count = $comment_count;
        }

        return $this->Hook->applyFilters('getCommentsNumber', $count, $post_id);
    }

    /**
     * Display the language string for the number of comments the current post has.
     *
     * @since 0.1.0
     * @uses applyFilters() Calls the 'commentsNumber' hook on the output and number of comments respectively.
     *
     * @param string $zero Text for no comments
     * @param string $one Text for one comment
     * @param string $more Text for more than one comment
     */
    public function commentsNumber($zero = false, $one = false, $more = false)
    {
        $number = $this->getCommentsNumber();

        if ($number > 1) {
            $output = str_replace(
                '%',
                Functions::number_format_i18n($number),
                (false === $more) ? __('% Comments') : $more
            );
        } elseif ($number == 0) {
            $output = (false === $zero) ? __('No Comments') : $zero;
        } else // must be one
        {
            $output = (false === $one) ? __('1 Comment') : $one;
        }

        echo $this->Hook->applyFilters('commentsNumber', $output, $number);
    }

    /**
     * Retrieve the text of the current comment.
     *
     * @since 0.1.0
     *
     * @return string The comment content
     */
    public function getCommentText()
    {
        return $this->Hook->applyFilters('getCommentText', $this->comment['content']);
    }

    /**
     * Displays the text of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilters() Passes the comment content through the 'commentText' hook before display
     * @uses getCommentText() Gets the comment content
     */
    public function commentText()
    {
        echo $this->Hook->applyFilters('commentText', $this->getCommentText());
    }

    /**
     * Retrieve the comment time of the current comment.
     *
     * @since 0.1.0
     * @uses applyFilter() Calls 'getCommentTime' hook with the formatted time, the $d parameter.
     *
     * @param string $d Optional. The format of the time (defaults to user's config)
     *
     * @return string The formatted time
     */
    public function getCommentTime($d = '')
    {
        if ('' == $d) {
            $date = $this->Time->format(
                Configure::read('General.time_format'),
                $this->comment['created'],
                null,
                Configure::read('General.timezone')
            );
        } else {
            $date = $this->Time->format($d, $this->comment['created'], null, Configure::read('General.timezone'));
        }
        return $this->Hook->applyFilters('getCommentTime', $date, $d);
    }

    /**
     * Display the comment time of the current comment.
     *
     * @since 0.1.0
     *
     * @param string $d Optional. The format of the time (defaults to user's config)
     */
    function commentTime($d = '')
    {
        echo $this->getCommentTime($d);
    }

    /**
     * The status of a comment.
     *
     * @since 0.1.0
     *
     * @param int $approved Comment Status
     *
     * @return string|bool Status might be 'trash', 'approved', 'unapproved', 'spam'. False on failure.
     */
    function getCommentStatus($approved)
    {
        if ($approved == null) {
            return false;
        } elseif ($approved == '1') {
            return 'approved';
        } elseif ($approved == '0') {
            return 'unapproved';
        } elseif ($approved == 'spam') {
            return 'spam';
        } elseif ($approved == 'trash') {
            return 'trash';
        } else {
            return false;
        }
    }

    /**
     * Whether the current post is open for comments.
     *
     * @since 0.1.0
     *
     * @return bool True if the comments are open
     */
    public function commentsOpen()
    {
        if ($this->view_path == 'Posts') {
            $comment_status = ('open' == $this->post['Post']['comment_status']);
        } elseif ($this->view_path == 'Pages') {
            $comment_status = ('open' == $this->page['Page']['comment_status']);
        }

        $open = ('open' == $comment_status);
        return $this->Hook->applyFilters('commentsOpen', $open);
    }

    /**
     * Displays the link to the comments popup window for the current post ID.
     *
     * Is not meant to be displayed on single posts and pages. Should be used on the
     * lists of posts
     *
     * @since 0.1.0
     *
     * @param string $zero The string to display when no comments
     * @param string $one The string to display when only one comment is available
     * @param string $more The string to display when there are more than one comment
     * @param string $css_class The CSS class to use for comments
     * @param string $none The string to display when comments have been turned off
     *
     * @return null Returns null on single posts and pages.
     */
    public function commentsPopupLink($zero = false, $one = false, $more = false, $css_class = '', $none = false)
    {
        if (false === $zero) {
            $zero = __('No Comments');
        }
        if (false === $one) {
            $one = __('1 Comment');
        }
        if (false === $more) {
            $more = __('% Comments');
        }
        if (false === $none) {
            $none = __('Comments Off');
        }

        $number = $this->getCommentsNumber();

        if (0 == $number && !$this->commentsOpen()) {
            echo '<span' . ((!empty($css_class)) ? ' class="' . Formatting::esc_attr(
                        $css_class
                    ) . '"' : '') . '>' . $none . '</span>';
            return;
        }

        echo '<a href="';

        if (0 == $number) {
            echo $this->Link->getPermalink() . '#respond';
        } else {
            $this->commentsLink();
        }
        echo '"';

        if (!empty($css_class)) {
            echo ' class="' . $css_class . '" ';
        }

        if ($this->view_path == 'Posts') {
            $title = $this->Post->theTitleAttribute(array('echo' => 0));
        } elseif ($this->view_path == 'Pages') {
            $title = $this->Page->theTitleAttribute(array('echo' => 0));
        }

        echo $this->Hook->applyFilters('comments_popup_link_attributes', '');

        echo ' title="' . Formatting::esc_attr(sprintf(__('Comment on %s'), $title)) . '">';
        $this->commentsNumber($zero, $one, $more);
        echo '</a>';
    }

    public function comments_template()
    {
        if ($this->commentsOpen()) {
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

    protected function _loggedin_comment_form()
    {
        echo '<div id="respond">';
        echo '<h3 id="reply-title">' . __('Leave a Reply') . '</h3>';

        echo $this->Form->create(
            'Comment',
            array(
                'action' => 'add',
                'id' => 'commentform',
                'inputDefaults' => array(
                    'label' => false,
                    'div' => false
                )
            )
        );

        echo '<p class="logged-in-as">';
        echo __(
            'Logged in as %s. ',
            $this->Html->link(
                $this->current_user['username'],
                array('admin' => true, 'controller' => 'users', 'action' => 'profile', $this->current_user['id'])
            )
        );
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
        echo $this->Form->end(array('label' => __('Post Comment'), 'div' => false, 'tabindex' => '5'));
        echo '</p>';

        echo '<div style = "clear: both;"></div>';
        echo '</div>';
    }

    protected function _loggedout_comment_form()
    {
        echo '<div id="respond">';
        echo '<h3 id="reply-title">' . __('Leave a Reply') . '</h3>';

        echo $this->Form->create(
            'Comment',
            array(
                'action' => 'add',
                'id' => 'commentform',
                'inputDefaults' => array(
                    'label' => false,
                    'div' => false
                )
            )
        );
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
        echo $this->Form->end(array('label' => __('Post Comment'), 'div' => false, 'tabindex' => '5'));
        echo '</p>';

        echo '<div style = "clear: both;"></div>';
        echo '</div>';
    }

    protected function _comment_list()
    {
        if ($this->view_path == 'Posts') {
            $comments = $this->post['Comment'];
        } elseif ($this->view_path == 'Pages') {
            $comments = $this->page['Comment'];
        }
        echo '<h4 class = "comment-title">' . $this->post['Post']['comment_count'] . ' Comment</h4>';
        echo '<ol class = "commentlist">';
        foreach ($comments as $comment) {
            $this->setComment($comment);
            echo '<li id = "comment-' . $this->getCommentID() . '" ' . $this->commentClass('', false) . '>';
            echo '<p class = "comment-author">';
            echo $this->Gravatar->image($this->getCommentAuthorEmail(), array('size' => '48', 'default' => 'mm'));
            echo '<cite>';
            echo $this->getCommentAuthorUrlLink($this->getCommentAuthor());
            echo '</cite>';
            echo '<br>';
            echo '<small class = "comment-time">';
            echo '<strong>' . $this->getCommentDate() . '</strong>';
            echo ' @ ' . $this->getCommentTime();
            echo '</small>';
            echo '</p>';
            echo '<div class = "commententry">';
            $this->commentText();
            echo '</div>';
            echo '<p class="reply"> </p>';
            echo '</li>';
        }

        echo '</ol>';
    }

}