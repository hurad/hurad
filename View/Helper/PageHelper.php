<?php

class PageHelper extends AppHelper {

    public $helpers = array('Html', 'Time');
    public $page = array();
    public $pages = array();
    public $view = null;
    public $view_path = null;

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->init();
        $this->init_page();
    }

    public function init() {
        $this->view = $this->_View->view;
        $this->view_path = $this->_View->viewPath;
    }

    public function setPage($page) {
        $this->page = $page;
    }

    protected function init_page() {
        if ($this->view_path == 'Pages') {
            if ($this->view == 'view' || $this->view == 'viewByid') {
                $this->page = $this->_View->getVar('page');
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Retrieve full permalink for current page.
     *
     * @since 0.1
     *
     * @return string
     */
    public function get_permalink() {
        $year = $this->Time->format('Y', $this->page['Page']['created']);
        $month = $this->Time->format('m', $this->page['Page']['created']);
        $day = $this->Time->format('d', $this->page['Page']['created']);

        if (Configure::read('Permalink-common') == 'default') {
            return $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->page['Page']['id']);
        } else {
            return $this->Html->url(Configure::read('General-site_url') . "/page/" . $this->page['Page']['slug']);
        }
    }

    /**
     * Display the permalink for the current page.
     *
     * @since 0.1
     */
    public function the_permalink() {
        echo $this->get_permalink();
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
     * @uses $page
     * 
     * @return int
     */
    public function get_the_ID() {
        return $this->page['Page']['id'];
    }

    /**
     * Display or retrieve the current page title with optional content.
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
     * @since 1.0
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
     * Retrieve page title.
     *
     * @since 0.1
     *
     * @return string
     */
    public function get_the_title() {
        return $this->page['Page']['title'];
    }

    /**
     * Display the page excerpt.
     *
     * @since 0.1
     * @uses get_the_excerpt() Echos Result
     */
    function the_excerpt() {
        echo $this->get_the_excerpt();
    }

    /**
     * Retrieve the page excerpt.
     *
     * @since 0.1
     * @uses $page
     * 
     * @return string
     */
    function get_the_excerpt() {
        return $this->page['Page']['excerpt'];
    }

    /**
     * Whether page has excerpt.
     *
     * @since 0.1
     *
     * @return bool
     */
    function has_excerpt() {
        return (!empty($this->page['Page']['excerpt']) );
    }

    /**
     * Display or Retrieve the date the current $page was written (once per date)
     *
     * Will only output the date if the current page's date is different from the
     * previous one output.
     *
     * i.e. Only one date listing will show per day worth of pages shown in the loop, even if the
     * function is called several times for each page.
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
     * Retrieve the date the current $page was written.
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
            $the_date .= $this->Time->format(Configure::read('General-date_format'), $this->page['Page']['created'], null, Configure::read('General-timezone'));
        else
            $the_date .= $this->Time->format($format, $this->page['Page']['created'], null, Configure::read('General-timezone'));

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

    /**
     * Converts formatted string to array
     *
     * A string formatted like 'sort=title;' will be converted to
     * array('sort' => 'title');
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