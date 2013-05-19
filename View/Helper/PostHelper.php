<?php

App::uses('AppHelper', 'View/Helper');

class PostHelper extends AppHelper {

    /**
     * Other helpers used by this helper.
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Time', 'General', 'Link', 'Hook', 'Author');

    /**
     * Current post array.
     *
     * @var array
     * @access public
     */
    public $post = array();

    /**
     * Current view file.
     *
     * @var string
     * @access public
     */
    public $view = null;

    /**
     * Current view directory.
     *
     * @var string
     * @access public
     */
    public $view_path = null;

    public function __construct(\View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->_init();
    }

    private function _init() {
        $this->view = $this->_View->view;
        $this->view_path = $this->_View->viewPath;

        if ($this->view_path == 'Posts') {
            if ($this->view == 'view' || $this->view == 'viewByid') {
                $this->Link->post = $this->General->post = $this->post = $this->_View->getVar('post');
            }
        } else {
            return FALSE;
        }
    }

    public function setPost($post) {
        $this->post = $post;
        $this->General->content = $post;
        $this->Link->post = $post;
        $this->Author->setAuthor($post['Post']['user_id'], $post['Post']['id']);
    }

    /**
     * Display the ID of the current item in the Hurad Loop.
     *
     * @since 1.0.0
     */
    public function theID() {
        echo $this->getTheID();
    }

    /**
     * Retrieve the ID of the current item in the Hurad Loop.
     *
     * @since 1.0.0
     * @uses $post
     * 
     * @return int
     */
    public function getTheID() {
        return $this->post['Post']['id'];
    }

    /**
     * Display or retrieve the current post title with optional content.
     *
     * @since 1.0.0
     *
     * @param string $before Optional. Content to prepend to the title.
     * @param string $after Optional. Content to append to the title.
     * @param bool $echo Optional, default to true.Whether to display or return.
     * @return null|string Null on no title. String if $echo parameter is false.
     */
    public function theTitle($before = '', $after = '', $echo = true) {
        $title = $this->getTheTitle();

        if (strlen($title) == 0)
            return;

        $title = $before . $title . $after;

        if ($echo)
            echo $title;
        else
            return $title;
    }

    /**
     * Sanitize the current title when retrieving or displaying.
     *
     * Works like {@link theTitle()}, except the parameters can be in a string or
     * an array. See the function for what can be override in the $args parameter.
     *
     * The title before it is displayed will have the tags stripped before it
     * is passed to the user or displayed. The default
     * as with {@link theTitle()}, is to display the title.
     *
     * @since 1.0.0
     *
     * @param string|array $args Optional. Override the defaults.
     * @return string|null Null on failure or display. String when echo is false.
     */
    public function theTitleAttribute($args = '') {
        $title = $this->getTheTitle();

        if (strlen($title) == 0)
            return;

        $defaults = array('before' => '', 'after' => '', 'echo' => true);
        $r = Functions::hr_parse_args($args, $defaults);
        extract($r, EXTR_SKIP);

        $title = $before . $title . $after;
        $title = Formatting::esc_attr(strip_tags($title));

        if ($echo)
            echo $title;
        else
            return $title;
    }

    /**
     * Retrieve post title.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getTheTitle() {
        $title = isset($this->post['Post']['title']) ? $this->post['Post']['title'] : '';
        return $this->Hook->applyFilters('the_title', $title);
    }

    /**
     * Display the post content.
     *
     * @since 1.0.0
     *
     * @param string $more_link_text Optional. Content for when there is more text.
     */
    public function theContent($more_link_text = null) {
        $content = $this->getTheContent($more_link_text);
        $content = $this->Hook->applyFilters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        echo $content;
    }

    /**
     * Retrieve the post content.
     *
     * @since 1.0.0
     *
     * @param string $more_link_text Optional. Content for when there is more text.
     * @return string
     */
    public function getTheContent($more_link_text = null) {
        if (null === $more_link_text) {
            $more_link_text = __('(more...)');
        }
        $more = FALSE;
        $output = '';
        $hasTeaser = false;
        $content = $this->post['Post']['content'];
        if (preg_match('/<!--more(.*?)?-->/', $content, $matches)) {
            $more = TRUE;
            $content = explode($matches[0], $content, 2);
            if (!empty($matches[1]) && !empty($more_link_text)) {
                $more_link_text = strip_tags(kses_no_null(trim($matches[1])));
            }
            $hasTeaser = true;
        } else {
            $content = array($content);
        }
        $teaser = $content[0];
        $output .= $teaser;
        if (count($content) > 1) {
            if ($more && $this->view == 'view') {
                $output .= $this->Html->tag('span', NULL, array('id' => 'more-' . $this->getTheID())) . $content[1];
            } else {
                if (!empty($more_link_text)) {
                    $output .= $this->Hook->applyFilters('the_content_more_link', $this->Html->link($more_link_text, $this->getPermalink() . '#more-' . $this->getTheID(), array('class' => 'more-link')), $more_link_text);
                }
                $output = Formatting::force_balance_tags($output);
            }
        }
        return $output;
    }

    /**
     * Display the post excerpt.
     *
     * @since 1.0.0
     * @uses apply_filters() Calls 'the_excerpt' hook on post excerpt.
     */
    public function theExcerpt() {
        echo $this->Hook->applyFilters('the_excerpt', $this->getTheExcerpt());
    }

    /**
     * Retrieve the post excerpt.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getTheExcerpt() {
        return $this->Hook->applyFilters('get_the_excerpt', $this->post['Post']['excerpt']);
    }

    /**
     * Whether post has excerpt.
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function hasExcerpt() {
        return (!empty($this->post['Post']['excerpt']) );
    }

    /**
     * Display the classes for the post div.
     *
     * @since 1.0.0
     *
     * @param string|array $class One or more classes to add to the class list.
     */
    public function postClass($class = '') {
        // Separates classes with a single space, collates classes for post DIV
        echo 'class="' . join(' ', $this->getPostClass($class)) . '"';
    }

    /**
     * Retrieve the classes for the post div as an array.
     *
     * The class names are add are many. If the post is a sticky, then the 'sticky'
     * class name. The class 'hentry' is always added to each post. All classes are 
     * passed through the filter, 'post_class' with the list of classes, followed 
     * by $class parameter value.
     *
     * @since 1.0.0
     *
     * @param string|array $class One or more classes to add to the class list.
     * @return array Array of classes.
     */
    public function getPostClass($class = '') {

        $classes = array();

        $classes[] = 'post-' . $this->post['Post']['id'];
        if (!Functions::is_admin()) {
            $classes[] = $this->post['Post']['type'];
        }
        $classes[] = 'type-' . $this->post['Post']['type'];
        $classes[] = 'status-' . $this->post['Post']['status'];

        // hentry for hAtom compliance
        $classes[] = 'hentry';

        if (!empty($class)) {
            if (!is_array($class)) {
                $class = preg_split('#\s+#', $class);
            }
            $classes = array_merge($classes, $class);
        }

        $classes = array_map('Formatting::esc_attr', $classes);

        return $this->Hook->applyFilters('post_class', $classes, $class);
    }

    public function the_category($separator = ', ', $echo = true) {
        $cat = array();
        foreach ($this->post['Category'] as $category) {
            if (isset($this->request->params['admin'])) {
                $cat[] = $this->Html->link($category['name'], array('admin' => TRUE, 'controller' => 'posts', 'action' => 'listBycategory', $category['id']), array('title' => __('View all posts in %s', $category['name']), 'rel' => 'category'));
            } else {
                $cat[] = '<a href="http://localhost/hurad/category/' . $category['slug'] . '" title="' . __('View all posts in') . ' ' . $category['name'] . '" rel="category">' . $category['name'] . '</a>';
            }
        }
        if ($separator == '') {
            $separator = ', ';
        }
        if ($echo) {
            echo implode($separator, $cat);
        } else {
            return implode($separator, $cat);
        }
    }

    public function tag($separator = ', ', $echo = true) {
        $term = array();
        foreach ($this->post['Tag'] as $tag) {
            if (isset($this->request->params['admin'])) {
                $term[] = $this->Html->link($tag['name'], array('admin' => TRUE, 'controller' => 'posts', 'action' => 'listBytag', $tag['id']), array('title' => __('View all posts in %s', $tag['name']), 'rel' => 'tag'));
            } else {
                $term[] = '<a href="http://localhost/hurad/tag/' . $tag['slug'] . '" title="' . __('View all posts in') . ' ' . $tag['name'] . '" rel="tag">' . $tag['name'] . '</a>';
            }
        }
        if ($separator == '') {
            $separator = ', ';
        }
        if ($echo) {
            echo implode($separator, $term);
        } else {
            return implode($separator, $term);
        }
    }

    /**
     * Display the permalink for the current post.
     *
     * @since 1.0.0
     */
    public function thePermalink() {
        $this->Link->thePermalink();
    }

    /**
     * Retrieve full permalink for current post.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function getPermalink() {
        return $this->Link->getPermalink();
    }

    /**
     * Display or Retrieve the date the current $post was written (once per date)
     *
     * Will only output the date if the current post's date is different from the
     * previous one output.
     *
     * i.e. Only one date listing will show per day worth of posts shown in the loop, even if the
     * function is called several times for each post.
     *
     * HTML output can be filtered with 'the_date'.
     * Date string output can be filtered with 'get_the_date'.
     *
     * @since 1.0.0
     * @uses get_the_date()
     * @param string $d Optional. PHP date format defaults to the date_format option if not specified.
     * @param string $before Optional. Output before the date.
     * @param string $after Optional. Output after the date.
     * @param bool $echo Optional, default is display. Whether to echo the date or return it.
     * @return string|null Null if displaying, string if retrieving.
     */
    public function theDate($d = '', $before = '', $after = '', $echo = true) {
        $this->General->theDate($d, $before, $after, $echo);
    }

    /**
     * Retrieve the date the current $post was written.
     *
     * Unlike the_date() this function will always return the date.
     * Modify output with 'get_the_date' filter.
     *
     * @since 1.0.0
     *
     * @param string $d Optional. PHP date format defaults to the date_format option if not specified.
     * @return string|null Null if displaying, string if retrieving.
     */
    public function getTheDate($d = '') {
        return $this->General->getTheDate($d);
    }

    public function list_pages($args = '') {
        $defaults = array(
            'direction' => 'asc',
            'sort' => 'title',
            'echo' => 1,
            'link_before' => '',
            'link_after' => '',
        );
        //$narr = merge $args with $defaults
        $narr = Functions::hr_parse_args($args, $defaults);
        $pages = $this->requestAction('/posts/pageIndex/sort:' . $narr['sort'] . '/direction:' . $narr['direction']);
        $output = $this->page_tree_render($pages, $narr);
        if ($narr['echo']) {
            echo $output;
        } else {
            return $output;
        }
    }

    /**
     * Returns a page nested list for data generated by find('threaded')
     *
     * @param $pages array Data generated by find('threaded')
     * 
     * @return string HTML for nested list
     * */
    public function page_tree_render($pages, $narr = array()) {
        $out = NULL;
        foreach ($pages as $page) {
            $out .= '<li class="page_item page-item-' . $page['Post']['id'] . '">';
            $out .= $this->Html->link($page['Post']['title'], '/pages/' . $page['Post']['slug']);
            if (isset($page['children']) && !empty($page['children'])) {
                $out .= '<ul class="children">';
                $out .= $this->page_tree_render($page['children']);
                $out .= '</ul>';
            }
            $out .= '</li>';
        }
        return $out;
    }

    public function list_categories($args = array()) {
        $defaults = array(
            'direction' => 'asc',
            'sort' => 'name',
            'echo' => 1,
        );
        //$narr = merge $args with $defaults
        $narr = Functions::hr_parse_args($args, $defaults);
        $cats = $this->requestAction('/categories/index/sort:' . $narr['sort'] . '/direction:' . $narr['direction']);
        $output = $this->category_tree_render($cats);
        if ($narr['echo']) {
            echo $output;
        } else {
            return $output;
        }
    }

    /**
     * Returns a category nested list for data generated by find('threaded')
     *
     * @param $cats array Data generated by find('threaded')
     * 
     * @return string HTML for nested list
     * */
    public function category_tree_render($cats) {
        $out = NULL;
        foreach ($cats as $cat) {
            $out .= '<li class="cat_item cat-item-' . $cat['Category']['id'] . '">';
            $out .= $this->Html->link($cat['Category']['name'], '/category/' . $cat['Category']['slug']);
            $out .= ' (' . $cat['Category']['post_count'] . ')';
            if (isset($cat['children']) && !empty($cat['children'])) {
                $out .= '<ul class="children">';
                $out .= $this->category_tree_render($cat['children']);
                $out .= '</ul>';
            }
            $out .= '</li>';
        }
        return $out;
    }

    /**
     * Converts formatted string to array
     *
     * A string formatted like 'sort=title;' will be converted to
     * array('sort' => 'blog');
     *
     * @param string $string in this format: sort=title;direction=asc;
     * @return array
     */
    public function stringToArray($string) {
        $string = explode(';', $string);
        $stringArr = array();
        foreach ($string as $stringElement) {
            if ($stringElement != null) {
                $stringElementE = explode('=', $stringElement);
                if (isset($stringElementE['1'])) {
                    $stringArr[$stringElementE['0']] = $stringElementE['1'];
                } else {
                    $stringArr[] = $stringElement;
                }
            }
        }

        return $stringArr;
    }

}