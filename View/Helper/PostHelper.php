<?php

class PostHelper extends AppHelper {

    public $helpers = array('Html', 'Time');
    public $post = array();
    public $posts = array();
    public $view = null;
    public $view_path = null;

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->init();
        $this->init_post();
    }

    public function init() {
        $this->view = $this->_View->view;
        $this->view_path = $this->_View->viewPath;
    }

    public function setPost($post) {
        $this->post = $post;
    }

    protected function init_post() {
        if ($this->view_path == 'Posts') {
            if ($this->view == 'view' || $this->view == 'viewByid') {
                $this->post = $this->_View->getVar('post');
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Display the ID of the current item in the Hurad Loop.
     *
     * @since 0.1
     */
    public function the_ID() {
        echo $this->get_the_ID();
    }

    /**
     * Retrieve the ID of the current item in the Hurad Loop.
     *
     * @since 0.1
     * @uses $post
     * 
     * @return int
     */
    public function get_the_ID() {
        return $this->post['Post']['id'];
    }

    /**
     * Display or retrieve the current post title with optional content.
     *
     * @since 0.1
     *
     * @param string $before Optional. Content to prepend to the title.
     * @param string $after Optional. Content to append to the title.
     * @param bool $echo Optional, default to true.Whether to display or return.
     * @return null|string Null on no title. String if $echo parameter is false.
     */
    public function the_title($before = '', $after = '', $echo = true) {
        $title = $this->get_the_title();

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
     * Works like {@link the_title()}, except the parameters can be in a string or
     * an array. See the function for what can be override in the $args parameter.
     *
     * The title before it is displayed will have the tags stripped before it
     * is passed to the user or displayed. The default
     * as with {@link the_title()}, is to display the title.
     *
     * @since 0.
     *
     * @param string|array $args Optional. Override the defaults.
     * @return string|null Null on failure or display. String when echo is false.
     */
    function the_title_attribute($args = '') {
        $title = $this->get_the_title();

        if (strlen($title) == 0)
            return;

        $defaults = array('before' => '', 'after' => '', 'echo' => true);
        $r = $this->parse_args($args, $defaults);

        $title = $r['before'] . $title . $r['after'];
        $title = strip_tags($title);

        if ($r['echo'])
            echo $title;
        else
            return $title;
    }

    /**
     * Retrieve post title.
     *
     * @since 0.1
     *
     * @return string
     */
    public function get_the_title() {
        return $this->post['Post']['title'];
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
     * Retrieve full permalink for current post.
     *
     * @since 0.1
     *
     * @return string
     */
    public function get_permalink() {
        $year = $this->Time->format('Y', $this->post['Post']['created']);
        $month = $this->Time->format('m', $this->post['Post']['created']);
        $day = $this->Time->format('d', $this->post['Post']['created']);
        if ($this->post['Post']['type'] == 'post') {
            switch (Configure::read('Permalink-common')) {
                case 'default':
                    return $this->Html->url(Configure::read('General-site_url') . "/p/" . $this->post['Post']['id']);
                    break;
                case 'day_name':
                    return $this->Html->url(Configure::read('General-site_url') . "/" . $year . "/" . $month . "/" . $day . "/" . $this->post['Post']['slug']);
                    break;
                case 'month_name':
                    return $this->Html->url(Configure::read('General-site_url') . "/" . $year . "/" . $month . "/" . $this->post['Post']['slug']);
                    break;
                default:
                    break;
            }
        } elseif ($this->post['Post']['type'] == 'page') {
            if (Configure::read('Permalink-common') == 'default') {
                return $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->post['Post']['id']);
            } else {
                return $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->post['Post']['slug']);
            }
        }
    }

    /**
     * Display the permalink for the current post.
     *
     * @since 0.1
     */
    public function the_permalink() {
        echo $this->get_permalink();
    }

    /**
     * Display the post excerpt.
     *
     * @since 0.1
     * @uses get_the_excerpt() Echos Result
     */
    function the_excerpt() {
        echo $this->get_the_excerpt();
    }

    /**
     * Retrieve the post excerpt.
     *
     * @since 0.1
     * @uses $post
     * 
     * @return string
     */
    function get_the_excerpt() {
        return $this->post['Post']['excerpt'];
    }

    /**
     * Whether post has excerpt.
     *
     * @since 0.1
     *
     * @return bool
     */
    function has_excerpt() {
        return (!empty($this->post['Post']['excerpt']) );
    }

    /**
     * Display the classes for the post div.
     *
     * @since 1.0
     *
     * @param string|array $class One or more classes to add to the class list.
     */
    function post_class($class = '') {
        // Separates classes with a single space, collates classes for post DIV
        echo 'class="' . join(' ', $this->get_post_class($class)) . '"';
    }

    /**
     * Retrieve the classes for the post div as an array.
     *
     * The class names are add are many. If the post is a sticky, then the 'sticky'
     * class name. The class 'hentry' is always added to each post. All classes are 
     * passed through the filter, 'post_class' with the list of classes, followed 
     * by $class parameter value.
     *
     * @since 1.0
     *
     * @param string|array $class One or more classes to add to the class list.
     * @return array Array of classes.
     */
    function get_post_class($class = '') {

        $classes = array();

        $classes[] = 'post-' . $this->post['Post']['id'];
        if (!Functions::is_admin())
            $classes[] = $this->post['Post']['type'];
        $classes[] = 'type-' . $this->post['Post']['type'];
        $classes[] = 'status-' . $this->post['Post']['status'];

        // hentry for hAtom compliance
        $classes[] = 'hentry';

        if (!empty($class)) {
            if (!is_array($class))
                $class = preg_split('#\s+#', $class);
            $classes = array_merge($classes, $class);
        }

        $classes = array_map('Formatting::esc_attr', $classes);

        return $classes;
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
     * @since 0.1
     * @uses get_the_date()
     * @param string $format Optional. PHP date format defaults to the date_format option if not specified.
     * @param string $before Optional. Output before the date.
     * @param string $after Optional. Output after the date.
     * @param bool $echo Optional, default is display. Whether to echo the date or return it.
     * @return string|null Null if displaying, string if retrieving.
     */
    function the_date($format = '', $before = '', $after = '', $echo = true) {
        $the_date = '';

        $the_date .= $before;
        $the_date .= $this->get_the_date($format);
        $the_date .= $after;

        if ($echo)
            echo $the_date;
        else
            return $the_date;
    }

    /**
     * Retrieve the date the current $post was written.
     *
     * Unlike the_date() this function will always return the date.
     *
     * @since 0.1
     *
     * @param string $format Optional. PHP date format defaults to the date_format option if not specified.
     * @return string|null Null if displaying, string if retrieving.
     */
    function get_the_date($format = '') {
        $the_date = '';

        if ('' == $format)
            $the_date .= $this->Time->format(Configure::read('General-date_format'), $this->post['Post']['created'], null, Configure::read('General-timezone'));
        else
            $the_date .= $this->Time->format($format, $this->post['Post']['created'], null, Configure::read('General-timezone'));

        return $the_date;
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
        $narr = $this->parse_args($args, $defaults);
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

    public function list_categories($args = '') {
        $defaults = array(
            'direction' => 'asc',
            'sort' => 'name',
            'echo' => 1,
        );
        //$narr = merge $args with $defaults
        $narr = $this->parse_args($args, $defaults);
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

    public function parse_args($args, $defaults = array()) {
        if (is_string($args)) {
            $strArr = $this->stringToArray($args);
            return array_merge($defaults, $strArr);
        }
    }

}

?>