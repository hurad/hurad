<?php
/**
 * Comment helper
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
 * Class CommentHelper
 *
 * @property TreeHelper $Tree
 */
class CommentHelper extends AppHelper
{
    /**
     * Current Comment
     *
     * @var array
     * @access public
     */
    protected $comment = [];

    /**
     * Current User Logged
     *
     * @var array
     * @access public
     */
    public $currentUser = [];

    /**
     * Comment alt count
     *
     * @var object
     * @access public
     */
    public $commentAlt = null;

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = ['Hook', 'Html', 'Form', 'Time', 'Text', 'Gravatar', 'Content', 'Link', 'Utils.Tree'];

    /**
     * Current post array
     *
     * @var array
     * @access public
     */
    public $content = [];

    /**
     * Default Constructor
     *
     * @param View  $View     The View this helper is being attached to.
     * @param array $settings Configuration settings for the helper.
     */
    public function __construct(View $View, $settings = [])
    {
        parent::__construct($View, $settings);

        if ($this->_View->viewPath == 'Posts') {
            $this->content = $this->Link->post = $this->_View->get('post');
            $this->contentModel = 'Post';
            $this->contentType = 'post';
        } elseif ($this->_View->viewPath == 'Pages') {
            $this->content = $this->_View->get('page');
            $this->contentModel = 'Page';
            $this->contentType = 'page';
        }

        $this->currentUser = $this->_View->get('current_user');
    }

    /**
     * Set current comment
     *
     * @param array $comment Current comment
     */
    public function setComment(array $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comment
     *
     * @param array|string $comment Comment array or comment id
     * @param array        $query   Find query
     */
    protected function getComment($comment, array $query = [])
    {
        if (is_array($comment) && array_key_exists('Comment', $comment)) {
            $this->comment = $comment;
        } elseif (!is_null($comment)) {
            $comment = ClassRegistry::init('Comment')->getComment($comment, $query);
            $this->comment = $comment;
        }
    }

    /**
     * Retrieve the author of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string The comment author
     */
    public function getAuthor($comment = null)
    {
        $this->getComment($comment);

        if (empty($this->comment['Comment']['author'])) {
            if (!empty($this->comment['Comment']['user_id'])) {
                $user = ClassRegistry::init('User')->getUser($this->comment['Comment']['user_id']);
                $author = $user['User']['username'];
            } else {
                $author = __d('hurad', 'Anonymous');
            }
        } else {
            $author = $this->comment['Comment']['author'];
        }

        return $this->Hook->applyFilters('Helper.Comment.getAuthor', $author);
    }

    /**
     * Retrieve the email of the author of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string The current comment author's email
     */
    public function getAuthorEmail($comment = null)
    {
        $this->getComment($comment);

        return $this->Hook->applyFilters('Helper.Comment.getAuthorEmail', $this->comment['Comment']['author_email']);
    }

    /**
     * Return the html email link to the author of the current comment.
     *
     * @param string       $linkText The text to display instead of the comment author's email address
     * @param string       $before   The text or HTML to display before the email link.
     * @param string       $after    The text or HTML to display after the email link.
     * @param array|string $comment  Comment array or comment id
     *
     * @return string
     */
    public function getAuthorEmailLink($linkText = '', $before = '', $after = '', $comment = null)
    {
        $email = $this->getAuthorEmail($comment);

        if ((!empty($email)) && ($email != '@')) {
            $display = ($linkText != '') ? $linkText : $email;
            $return = $before;
            $return .= $this->Html->link($display, 'mailto:' . $email);
            $return .= $after;
        } else {
            $return = '';
        }

        return $this->Hook->applyFilters('Helper.Comment.getAuthorEmailLink', $return, $email);
    }

    /**
     * Retrieve the html link to the url of the author of the current comment.
     *
     * @param array|string $comment Comment array or comment id
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

        return $this->Hook->applyFilters('Helper.Comment.getAuthorLink', $return, $url, $author);
    }

    /**
     * Retrieve the IP address of the author of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string The comment author's IP address.
     */
    public function getAuthorIp($comment = null)
    {
        $this->getComment($comment);

        return $this->Hook->applyFilters('Helper.Comment.getAuthorIp', $this->comment['Comment']['author_ip']);
    }

    /**
     * Retrieve the url of the author of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string
     */
    public function getAuthorUrl($comment = null)
    {
        $this->getComment($comment);

        $url = ('http://' == $this->comment['Comment']['author_url']) ? '' : $this->comment['Comment']['author_url'];
        $url = HuradSanitize::url($url);

        return $this->Hook->applyFilters('Helper.Comment.getAuthorUrl', $url);
    }

    /**
     * Retrieves the HTML link of the url of the author of the current comment.
     *
     * @param string       $linkText The text to display instead of the comment author's email address
     * @param string       $before   The text or HTML to display before the email link.
     * @param string       $after    The text or HTML to display after the email link.
     * @param array|string $comment  Comment array or comment id
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

        return $this->Hook->applyFilters('Helper.Comment.getAuthorUrlLink', $return, $url);
    }

    /**
     * Returns the classes for the comment div as an array
     *
     * @param string|array $class   One or more classes to add to the class list
     * @param array|string $comment Comment array or comment id
     *
     * @return array Array of classes
     */
    public function getClass($class = '', $comment = null)
    {
        $this->getComment($comment);

        $classes = [];

        $classes[] = 'comment';

        // If the comment author has an id (registered), then print the log in name
        if ($this->comment['Comment']['user_id'] > 0 && $user = ClassRegistry::init('User')->getUser(
                $this->comment['Comment']['user_id']
            )
        ) {
            // For all registered users, 'byuser'
            $classes[] = 'byuser';
            $classes[] = 'comment-author-' . HuradSanitize::htmlClass(
                    [
                        'comment-author-' . $user['UserMeta']['nickname'],
                        'comment-author-' . $this->comment['Comment']['user_id']
                    ]
                );
            // For comment authors who are the author of the post
            if ($post = ClassRegistry::init('Post')->getPost($this->comment['Comment']['post_id'])) {
                if ($this->comment['Comment']['user_id'] === $post['Post']['user_id']) {
                    $classes[] = 'by-post-author';
                }
            }
        }

        if (empty($this->commentAlt)) {
            $this->commentAlt = 0;
        }

        if (empty($commentDepth)) {
            $commentDepth = 1;
        }

        if (empty($commentThreadAlt)) {
            $commentThreadAlt = 0;
        }

        if ($this->commentAlt % 2) {
            $classes[] = 'odd';
            $classes[] = 'alt';
        } else {
            $classes[] = 'even';
        }

        $this->commentAlt++;

        // Alt for top-level comments
        if (1 == $commentDepth) {
            if ($commentThreadAlt % 2) {
                $classes[] = 'thread-odd';
                $classes[] = 'thread-alt';
            } else {
                $classes[] = 'thread-even';
            }
            $commentThreadAlt++;
        }

        $classes[] = "depth-$commentDepth";

        if (!empty($class)) {
            if (!is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = Hash::merge($classes, $class);
        }

        $classes = array_map('HuradSanitize::htmlClass', $classes);
        $classesStr = implode(' ', $classes);

        return $this->Hook->applyFilters('Helper.Comment.getClass', $classesStr, $classes, $class);
    }

    /**
     * Retrieve the comment date of the current comment.
     *
     * @param string       $format
     * @param array|string $comment Comment array or comment id
     *
     * @return string The comment's date
     */
    public function getDate($format = '', $comment = null)
    {
        $this->getComment($comment);

        if ('' == $format) {
            $date = $this->Time->format(
                Configure::read('General.date_format'),
                $this->comment['Comment']['created'],
                null,
                Configure::read('General.timezone')
            );
        } else {
            $date = $this->Time->format(
                $format,
                $this->comment['Comment']['created'],
                null,
                Configure::read('General-timezone')
            );
        }

        return $this->Hook->applyFilters('Helper.Comment.getDate', $date, $format);
    }

    /**
     * Retrieve the excerpt of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string The maybe truncated comment with 20 words or less
     */
    public function getExcerpt($comment = null)
    {
        $this->getComment($comment);

        $commentText = strip_tags($this->comment['Comment']['content']);
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

        return $this->Hook->applyFilters('Helper.Comment.getExcerpt', $excerpt, $commentText);
    }

    /**
     * Retrieve the comment id of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return int The comment ID
     */
    public function getId($comment = null)
    {
        $this->getComment($comment);

        return $this->Hook->applyFilters('Helper.Comment.getId', $this->comment['Comment']['id']);
    }

    /**
     * Retrieves the link to the current post comments.
     *
     * @param bool|string $zero      Text for no comments
     * @param bool|string $one       Text for one comment
     * @param bool|string $more      Text for more than one comment
     * @param int         $contentId Post or Page id
     *
     * @return string The link to the comments
     */
    public function getCommentsLink($zero = false, $one = false, $more = false, $contentId = null)
    {
        $commentsUrl = $this->Content->getPermalink($contentId) . '#comments';
        $commentsLink = $this->Html->link($this->getCommentsNumber($zero, $one, $more, $contentId), $commentsUrl);

        return $this->Hook->applyFilters(
            'Helper.Comment.getCommentsLink',
            $commentsLink,
            $commentsUrl
        );
    }

    /**
     * Retrieve the amount of comments a post has.
     *
     * @param string $contentId Post id or Page id
     *
     * @return int The number of comments a post has
     */
    public function getCommentCount($contentId = null)
    {
        $this->Content->getContentData($contentId);

        $commentCount = $this->Content->content[$this->Content->contentModel]['comment_count'];
        $contentId = $this->Content->content[$this->Content->contentModel]['id'];

        if (!isset($commentCount)) {
            $count = 0;
        } else {
            $count = $commentCount;
        }

        return $this->Hook->applyFilters('Helper.Comment.getCommentCount', $count, $contentId);
    }

    /**
     * Display the language string for the number of comments the current post has.
     *
     * @uses applyFilters() Calls the 'comments_number' hook on the output and number of comments respectively.
     *
     * @param bool|string $zero      Text for no comments
     * @param bool|string $one       Text for one comment
     * @param bool|string $more      Text for more than one comment
     * @param int         $contentId Post or Page id
     *
     * @return mixed
     */
    public function getCommentsNumber($zero = false, $one = false, $more = false, $contentId = null)
    {
        $number = $this->getCommentCount($contentId);

        if ($number > 1) {
            $output = str_replace(
                '%',
                HuradFunctions::numberFormatI18n($number),
                (false === $more) ? __d('hurad', '% Comments') : $more
            );
        } elseif ($number == 0) {
            $output = (false === $zero) ? __d('hurad', 'No Comments') : $zero;
        } else {
            $output = (false === $one) ? __d('hurad', '1 Comment') : $one;
        }

        return $this->Hook->applyFilters('Helper.Comment.getCommentsNumber', $output, $number);
    }

    /**
     * Retrieve the text of the current comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string The comment content
     */
    public function getText($comment = null)
    {
        $this->getComment($comment);

        return $this->Hook->applyFilters('Helper.Comment.getText', $this->comment['Comment']['content']);
    }

    /**
     * Retrieve the comment time of the current comment.
     *
     * @param string       $format  Time format
     * @param array|string $comment Comment array or comment id
     *
     * @return string The formatted time
     */
    public function getTime($format = '', $comment = null)
    {
        $this->getComment($comment);

        if ('' == $format) {
            $date = $this->Time->format(
                Configure::read('General.time_format'),
                $this->comment['Comment']['created'],
                null,
                Configure::read('General.timezone')
            );
        } else {
            $date = $this->Time->format(
                $format,
                $this->comment['Comment']['created'],
                null,
                Configure::read('General.timezone')
            );
        }

        return $this->Hook->applyFilters('Helper.Comment.getTime', $date, $format);
    }

    /**
     * The status of a comment.
     *
     * @param array|string $comment Comment array or comment id
     *
     * @return string|bool Status might be 'trash', 'approved', 'unapproved', 'spam'. False on failure.
     */
    function getStatus($comment)
    {
        $this->getComment($comment);
        $output = Comment::getStatus($this->comment['Comment']['status']);

        return $this->Hook->applyFilters('Helper.Comment.getStatus', $output, $this->comment['Comment']['status']);
    }

    /**
     * The status of a comment.
     *
     * @param int    $contentId Post or Page id
     * @param string $text      Link text
     *
     * @return string|bool Status might be 'trash', 'approved', 'disapproved', 'spam'. False on failure.
     */
    function getCommentLink($contentId = null, $text = null)
    {
        if (!$text) {
            $text = $this->getText();
        }

        $link = $this->Html->link(
            $text,
            $this->Content->getPermalink($contentId) . '#comment-' . $this->getId()
        );

        return $this->Hook->applyFilters('Helper.Comment.getCommentLink', $link);
    }

    /**
     * Whether the current post is open for comments.
     *
     * @param int $contentId Post or Page id
     *
     * @return bool True if the comments are open
     */
    public function commentsIsOpen($contentId = null)
    {
        $this->Content->getContentData($contentId);

        $commentStatus = (Post::COMMENT_STATUS_OPEN == $this->Content->content[$this->Content->contentModel]['comment_status']);
        $open = (Post::COMMENT_STATUS_OPEN == $commentStatus);

        return $this->Hook->applyFilters('Helper.Comment.commentsIsOpen', $open);
    }

    /**
     * Show list of comments and submit form
     *
     * @param array $content Post or Page content
     *
     * @return string
     */
    public function template($content = null)
    {
        if ($content) {
            $this->content = $content;
        }

        return $this->_View->element('Comments/main', ['content' => $this->content]);
    }

    /**
     * Show submit form
     *
     * @param array $content Post or Page content
     *
     * @return string
     */
    public function form($content = null)
    {
        if ($content) {
            $this->content = $content;
        }

        if ($this->currentUser) {
            $elementPath = 'Comments/logged-in-form';
        } else {
            $elementPath = 'Comments/logged-out-form';
        }

        return $this->_View->element($elementPath, ['content' => $this->content]);
    }

    /**
     * Generate tree list comment
     *
     * @param array $content Post or Page content
     * @param array $settings
     *
     * @return string
     */
    public function treeList($content = null, $settings = [])
    {
        if ($content) {
            $this->content = $content;
        }

        $data = ClassRegistry::init('Comment')->getComments(
            $this->content[$this->contentModel]['id'],
            'all',
            ['conditions' => ['Comment.status' => Comment::STATUS_APPROVED]]
        );

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
            ['comment' => $data['data'], 'data' => $data, 'content' => $this->content]
        );
    }
}
