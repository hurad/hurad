<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class CommentHelper
 *
 * @property TreeHelper $Tree
 */
class CommentHelper extends AppHelper
{

    /**
     * Current Post
     *
     * @var array
     * @access public
     */
    public $post = [];

    /**
     * Current Page
     *
     * @var array
     * @access public
     */
    public $page = [];

    /**
     * Current Comment
     *
     * @var array
     * @access public
     */
    public $comment = [];

    /**
     * Current User Logged
     *
     * @var array
     * @access public
     */
    public $current_user = [];

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
    public $helpers = ['Hook', 'Html', 'Form', 'Time', 'Text', 'Gravatar', 'Post', 'Page', 'Link', 'Utils.Tree'];

    /**
     * Current post array
     *
     * @var array
     * @access public
     */
    public $content = [];
    /**
     * Model of content
     *
     * @var null|string
     */
    private static $model = null;

    /**
     * Set model
     *
     * @return null|string
     */
    public static function getModel()
    {
        return self::$model;
    }

    /**
     * Get model
     *
     * @param null|string $model
     */
    public static function setModel($model)
    {
        self::$model = Inflector::singularize($model);
    }

    public function __construct(View $View, $settings = [])
    {
        parent::__construct($View, $settings);
        $this->view_path = $this->_View->viewPath;
        $this->post = $this->Link->post = $this->_View->get('post');
        $this->page = $this->_View->get('page');
        $this->current_user = $this->_View->get('current_user');
        $this->MUser = ClassRegistry::getObject('User');
        $this->MPost = ClassRegistry::getObject('Post');
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
     * @uses applyFilters() Calls 'get_comment_author' hook on the comment author
     *
     * @param null $comment
     *
     * @return string The comment author
     */
    public function getAuthor($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        if (empty($this->comment['author'])) {
            if (!empty($this->comment['user_id'])) {
                $user = $this->MUser->getUserData($this->comment['user_id']);
                $author = $user['username'];
            } else {
                $author = __d('hurad', 'Anonymous');
            }
        } else {
            $author = $this->comment['author'];
        }
        return $this->Hook->applyFilters('get_comment_author', $author);
    }

    /**
     * Retrieve the email of the author of the current comment.
     *
     * @uses applyFilters() Calls the 'get_comment_author_email' hook on the comment author email
     *
     * @param null $comment
     *
     * @return string The current comment author's email
     */
    public function getAuthorEmail($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        return $this->Hook->applyFilters('get_comment_author_email', $this->comment['author_email']);
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
     * @uses applyFilters() Calls 'author_email' hook for the display of the comment author's email
     *
     * @param string $linkText The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     * @param null $comment
     *
     * @return string
     */
    public function getAuthorEmailLink($linkText = '', $before = '', $after = '', $comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        $email = $this->Hook->applyFilters('author_email', $this->comment['author_email']);

        if ((!empty($email)) && ($email != '@')) {
            $display = ($linkText != '') ? $linkText : $email;
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
     * @uses getAuthorUrl() For retrieve the url of the author of the current comment.
     * @uses getAuthor() For retrieve the author of the current comment.
     * @uses applyFilters() Calls 'get_comment_author_link' hook on the complete link HTML or author
     *
     * @param null $comment
     *
     * @return string Comment Author name or HTML link for author's URL
     */
    public function getAuthorLink($comment = null)
    {
        $url = $this->getAuthorUrl($comment);
        $author = $this->getAuthor($comment);

        if (empty($url) || 'http://' == $url) {
            $return = $author;
        } else {
            $return = $this->Html->link('Enter', $url, ['class' => 'url', 'rel' => 'external nofollow']);
        }
        return $this->Hook->applyFilters('get_comment_author_link', $return);
    }

    /**
     * Retrieve the IP address of the author of the current comment.
     *
     * @uses applyFilters()
     *
     * @param null $comment
     *
     * @return string The comment author's IP address.
     */
    public function getAuthorIP($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        return $this->Hook->applyFilters('get_comment_author_ip', $this->comment['author_ip']);
    }

    /**
     * Retrieve the url of the author of the current comment.
     *
     * @uses applyFilters() Calls 'get_comment_author_url' hook on the comment author's URL
     *
     * @param null $comment
     *
     * @return string
     */
    public function getAuthorUrl($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        $url = ('http://' == $this->comment['author_url']) ? '' : $this->comment['author_url'];
        $url = HuradSanitize::url($url);
        return $this->Hook->applyFilters('get_comment_author_url', $url);
    }

    /**
     * Retrieves the HTML link of the url of the author of the current comment.
     *
     * $linkText parameter is only used if the URL does not exist for the comment
     * author. If the URL does exist then the URL will be used and the $linkText
     * will be ignored.
     *
     * Encapsulate the HTML link between the $before and $after. So it will appear
     * in the order of $before, link, and finally $after.
     *
     * @uses applyFilters() Calls the 'get_comment_author_url_link' on the complete HTML before returning.
     *
     * @param string $linkText The text to display instead of the comment author's email address
     * @param string $before The text or HTML to display before the email link.
     * @param string $after The text or HTML to display after the email link.
     * @param null $comment
     *
     * @return string The HTML link between the $before and $after parameters
     */
    public function getAuthorUrlLink($linkText = '', $before = '', $after = '', $comment = null)
    {
        $url = $this->getAuthorUrl($comment);
        $display = ($linkText != '') ? $linkText : $url;
        $display = str_replace('http://www.', '', $display);
        $display = str_replace('http://', '', $display);
        if ('/' == substr($display, -1)) {
            $display = substr($display, 0, -1);
        }
        $return = $before . $this->Html->link($display, $url, array('rel' => 'external')) . $after;
        return $this->Hook->applyFilters('get_comment_author_url_link', $return);
    }

    /**
     * Generates semantic classes for each comment element
     *
     * @param string|array $class One or more classes to add to the class list
     * @param bool $echo
     * @param null $comment
     *
     * @return string
     */
    public function commentClass($class = '', $echo = true, $comment = null)
    {
        $classes = join(' ', $this->getCommentClass($class, $comment));

        if ($echo) {
            echo $classes;
        } else {
            return $classes;
        }
    }

    /**
     * Returns the classes for the comment div as an array
     *
     * @param string|array $class One or more classes to add to the class list
     * @param null $comment
     *
     * @return array Array of classes
     */
    public function getCommentClass($class = '', $comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        $classes = [];

        // Get the comment type (comment, trackback),
        $classes[] = 'comment';

        // If the comment author has an id (registered), then print the log in name
        if ($this->comment['user_id'] > 0 && $user = $this->MUser->getUserData($this->comment['user_id'])) {
            // For all registered users, 'byuser'
            $classes[] = 'byuser';
            $classes[] = 'comment-author-' . HuradSanitize::htmlClass(
                    array('comment-author-' . $user['nickname'], 'comment-author-' . $this->comment['user_id'])
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

        $classes = array_map('HuradSanitize::htmlClass', $classes);

        return $this->Hook->applyFilters('getCommentClass', $classes, $class);
    }

    /**
     * Retrieve the comment date of the current comment.
     *
     * @uses applyFilters() Calls 'get_comment_date' hook with the formatted date and the $d parameter respectively
     * @uses $comment
     *
     * @param string $d The format of the date (defaults to user's config)
     * @param null $comment
     *
     * @return string The comment's date
     */
    public function getDate($d = '', $comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        if ('' == $d) {
            $date = $this->Time->format(
                Configure::read('General.date_format'),
                $this->comment['created'],
                null,
                Configure::read('General.timezone')
            );
        } else {
            $date = $this->Time->format($d, $this->comment['created'], null, Configure::read('General-timezone'));
        }
        return $this->Hook->applyFilters('get_comment_date', $date, $d);
    }

    /**
     * Retrieve the excerpt of the current comment.
     *
     * Will cut each word and only output the first 20 words with '...' at the end.
     * If the word count is less than 20, then no truncating is done and no '...'
     * will appear.
     *
     * @uses applyFilters() Calls 'get_comment_excerpt' on truncated comment
     *
     * @param null $comment
     *
     * @return string The maybe truncated comment with 20 words or less
     */
    public function getExcerpt($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        $commentText = strip_tags($this->comment['content']);
        $blah = explode(' ', $commentText);

        if (count($blah) > 20) {
            $k = 20;
            $useDotDotDot = 1;
        } else {
            $k = count($blah);
            $useDotDotDot = 0;
        }

        $excerpt = '';
        for ($i = 0; $i < $k; $i++) {
            $excerpt .= $blah[$i] . ' ';
        }
        $excerpt .= ($useDotDotDot) ? '...' : '';
        return $this->Hook->applyFilters('get_comment_excerpt', $excerpt);
    }

    /**
     * Retrieve the comment id of the current comment.
     *
     * @uses applyFilters() Calls the 'get_comment_id' hook for the comment id
     *
     * @param null $comment
     *
     * @return int The comment ID
     */
    public function getId($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        return $this->Hook->applyFilters('get_comment_id', $this->comment['id']);
    }

    /**
     * Retrieves the link to the current post comments.
     *
     * @return string The link to the comments
     */
    public function getCommentsLink()
    {
        $commentsLink = $this->Post->getPermalink() . '#comments';
        return $this->Hook->applyFilters('get_comments_link', $commentsLink, $this->Post->getPermalink());
    }

    /**
     * Retrieve the amount of comments a post has.
     *
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
     * @uses applyFilters() Calls the 'commentsNumber' hook on the output and number of comments respectively.
     *
     * @param bool|string $zero Text for no comments
     * @param bool|string $one Text for one comment
     * @param bool|string $more Text for more than one comment
     */
    public function commentsNumber($zero = false, $one = false, $more = false)
    {
        $number = $this->getCommentsNumber();

        if ($number > 1) {
            $output = str_replace(
                '%',
                HuradFunctions::numberFormatI18n($number),
                (false === $more) ? __d('hurad', '% Comments') : $more
            );
        } elseif ($number == 0) {
            $output = (false === $zero) ? __d('hurad', 'No Comments') : $zero;
        } else // must be one
        {
            $output = (false === $one) ? __d('hurad', '1 Comment') : $one;
        }

        echo $this->Hook->applyFilters('commentsNumber', $output, $number);
    }

    /**
     * Retrieve the text of the current comment.
     *
     * @param null $comment
     *
     * @return string The comment content
     */
    public function getText($comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

        return $this->Hook->applyFilters('get_comment_text', $this->comment['content']);
    }

    /**
     * Retrieve the comment time of the current comment.
     *
     * @uses applyFilter() Calls 'get_comment_time' hook with the formatted time, the $d parameter.
     *
     * @param string $d Optional. The format of the time (defaults to user's config)
     * @param null $comment
     *
     * @return string The formatted time
     */
    public function getTime($d = '', $comment = null)
    {
        if ($comment) {
            $this->comment = $comment['Comment'];
        }

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

        return $this->Hook->applyFilters('get_comment_time', $date, $d);
    }

    /**
     * The status of a comment.
     *
     * @param int $approved Comment Status
     *
     * @return string|bool Status might be 'trash', 'approved', 'unapproved', 'spam'. False on failure.
     */
    function getCommentStatus($approved)
    {
        switch ($approved) {
            case'1';
                $output = __d('hurad', 'Approved');
                break;
            case'0':
                $output = __d('hurad', 'Unapproved');
                break;
            case'spam':
                $output = __d('hurad', 'Spam');
                break;
            case'trash':
                $output = __d('hurad', 'Trash');
                break;
            default:
                $output = __d('hurad', 'Unknown');
        }

        return $output;
    }

    /**
     * Whether the current post is open for comments.
     *
     * @return bool True if the comments are open
     */
    public function commentsOpen()
    {
        $comment_status = ('open' == $this->content[self::$model]['comment_status']);
        $open = ('open' == $comment_status);
        return $this->Hook->applyFilters('commentsOpen', $open);
    }

    /**
     * Displays the link to the comments popup window for the current post ID.
     *
     * Is not meant to be displayed on single posts and pages. Should be used on the
     * lists of posts
     *
     * @param bool|string $zero The string to display when no comments
     * @param bool|string $one The string to display when only one comment is available
     * @param bool|string $more The string to display when there are more than one comment
     * @param string $css_class The CSS class to use for comments
     * @param bool|string $none The string to display when comments have been turned off
     *
     * @return null Returns null on single posts and pages.
     */
    public function commentsPopupLink($zero = false, $one = false, $more = false, $css_class = '', $none = false)
    {
        if (false === $zero) {
            $zero = __d('hurad', 'No Comments');
        }
        if (false === $one) {
            $one = __d('hurad', '1 Comment');
        }
        if (false === $more) {
            $more = __d('hurad', '% Comments');
        }
        if (false === $none) {
            $none = __d('hurad', 'Comments Off');
        }

        $number = $this->getCommentsNumber();

        if (0 == $number && !$this->commentsOpen()) {
            echo '<span' . ((!empty($css_class)) ? ' class="' . HuradSanitize::htmlClass(
                        $css_class
                    ) . '"' : '') . '>' . $none . '</span>';
            return;
        }

        echo '<a href="';

        if (0 == $number) {
            echo $this->Link->getPermalink() . '#respond';
        } else {
            echo $this->getCommentsLink();
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

        echo ' title="' . HuradSanitize::htmlAttribute(sprintf(__d('hurad', 'Comment on %s'), $title)) . '">';
        $this->commentsNumber($zero, $one, $more);
        echo '</a>';
    }

    /**
     * Show list of comments and submit form
     *
     * @param null $post
     *
     * @return string
     */
    public function template($post = null)
    {
        if ($post) {
            $this->post = $post;
        }

        return $this->_View->element('Comments/main', ['post' => $this->post]);
    }

    /**
     * Show submit form
     *
     * @param null $post
     *
     * @return string
     */
    public function form($post = null)
    {
        if ($post) {
            $this->post = $post;
        }

        if ($this->current_user) {
            $elementPath = 'Comments/logged-in-form';
        } else {
            $elementPath = 'Comments/logged-out-form';
        }

        return $this->_View->element($elementPath, ['post' => $this->post]);
    }

    /**
     * Generate tree list comment
     *
     * @param null $post
     * @param array $settings
     *
     * @return string
     */
    public function treeList($post = null, $settings = [])
    {
        if ($post) {
            $this->post = $post;
        }

        $data = ClassRegistry::init('Comment')->getComments($this->post['Post']['id']);

        $defaults = [
            'callback' => [&$this, 'treeCallback'],
            'model' => 'Comment',
            'class' => 'comment-list'
        ];

        $settings = Hash::merge($defaults, $settings);

        return $this->Tree->generate($data, $settings);
    }

    /**
     * Callback tree item element
     *
     * @param $data
     *
     * @return string
     */
    public function treeCallback($data)
    {
        return $this->_View->element(
            'Comments/item',
            ['comment' => $data['data'], 'data' => $data, 'post' => $this->post]
        );
    }
}