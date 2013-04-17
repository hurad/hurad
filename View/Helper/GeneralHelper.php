<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Description of GeneralHelper
 *
 * @author mohammad
 */
class GeneralHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Time', 'Hook');

    /**
     * Current post array
     *
     * @var array
     * @access public
     */
    public $post = array();

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

        $the_date = '';

        $the_date .= $before;
        $the_date .= $this->getTheDate($d);
        $the_date .= $after;

        $the_date = $this->Hook->applyFilters('the_date', $the_date, $d, $before, $after);

        if ($echo) {
            echo $the_date;
        } else {
            return $the_date;
        }
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
        $the_date = '';

        if ('' == $d)
            $the_date .= $this->Time->format(Configure::read('General.date_format'), $this->post['Post']['created'], null, Configure::read('General.timezone'));
        else
            $the_date .= $this->Time->format($d, $this->post['Post']['created'], null, Configure::read('General.timezone'));

        return $this->Hook->applyFilters('get_the_date', $the_date, $d);
    }

    /**
     * Display the date on which the post was last modified.
     *
     * @since 1.0.0
     *
     * @param string $d Optional. PHP date format defaults to the date_format option if not specified.
     * @param string $before Optional. Output before the date.
     * @param string $after Optional. Output after the date.
     * @param bool $echo Optional, default is display. Whether to echo the date or return it.
     * @return string|null Null if displaying, string if retrieving.
     */
    public function theModifiedDate($d = '', $before = '', $after = '', $echo = true) {

        $the_modified_date = $before . $this->getTheModifiedDate($d) . $after;
        $the_modified_date = $this->Hook->applyFilters('the_modified_date', $the_modified_date, $d, $before, $after);

        if ($echo) {
            echo $the_modified_date;
        } else {
            return $the_modified_date;
        }
    }

    /**
     * Retrieve the date on which the post was last modified.
     *
     * @since 1.0.0
     *
     * @param string $d Optional. PHP date format. Defaults to the "date_format" option
     * @return string
     */
    public function getTheModifiedDate($d = '') {
        if ('' == $d) {
            $the_time = $this->getPostModifiedTime(Configure::read('General.date_format'));
        } else {
            $the_time = $this->getPostModifiedTime($d);
        }

        return $this->Hook->applyFilters('get_the_modified_date', $the_time, $d);
    }

    /**
     * Display the time at which the post was written.
     *
     * @since 1.0.0
     *
     * @param string $d Either 'G', 'U', or php date format.
     */
    public function theTime($d = '') {
        echo $this->Hook->applyFilters('the_time', $this->getTheTime($d), $d);
    }

    /**
     * Retrieve the time at which the post was written.
     *
     * @since 1.0.0
     *
     * @param string $d Optional Either 'G', 'U', or php date format defaults to the value specified in the time_format option.
     * @return string
     */
    public function getTheTime($d = '') {
        if ('' == $d) {
            $the_time = $this->getPostTime(Configure::read('General.time_format'));
        } else {
            $the_time = $this->getPostTime($d);
        }

        return $this->Hook->applyFilters('get_the_time', $the_time, $d);
    }

    /**
     * Retrieve the time at which the post was written.
     *
     * @since 1.0.0
     *
     * @param string $d Optional Either 'G', 'U', or php date format.
     * @return string
     */
    public function getPostTime($d = 'U') { // returns timestamp
        $time = $this->post['Post']['created'];
        $time = $this->Time->format($d, $time, null, Configure::read('General.timezone'));

        return $this->Hook->applyFilters('get_post_time', $time, $d);
    }

    /**
     * Display the time at which the post was last modified.
     *
     * @since 1.0.0
     *
     * @param string $d Optional Either 'G', 'U', or php date format defaults to the value specified in the time_format option.
     */
    public function theModifiedTime($d = '') {
        echo $this->Hook->applyFilters('the_modified_time', $this->getTheModifiedTime($d), $d);
    }

    /**
     * Retrieve the time at which the post was last modified.
     *
     * @since 1.0.0
     *
     * @param string $d Optional Either 'G', 'U', or php date format defaults to the value specified in the time_format option.
     * @return string
     */
    public function getTheModifiedTime($d = '') {
        if ('' == $d) {
            $the_time = $this->getPostModifiedTime(Configure::read('General.time_format'));
        } else {
            $the_time = $this->getPostModifiedTime($d);
        }

        return $this->Hook->applyFilters('get_the_modified_time', $the_time, $d);
    }

    /**
     * Retrieve the time at which the post was last modified.
     *
     * @since 1.0.0
     *
     * @param string $d Optional, default is 'U'. Either 'G', 'U', or php date format.
     * @return string Returns timestamp
     */
    public function getPostModifiedTime($d = 'U') {
        $time = $this->post['Post']['modified'];
        $time = $this->Time->format($d, $time, null, Configure::read('General.timezone'));

        return $this->Hook->applyFilters('get_post_modified_time', $time, $d);
    }

}