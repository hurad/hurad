<?php

/**
 * The Hook API is located in this file, which allows for creating actions
 * and filters and hooking functions, and methods. The functions or methods will
 * then be run when the action or filter is called.
 *
 * The API callback examples reference functions, but can be methods of classes.
 * To hook methods, you'll need to pass an array one of two ways.
 *
 * Any of the syntaxes explained in the PHP documentation for the
 * {@link http://us2.php.net/manual/en/language.pseudo-types.php#language.types.callback 'callback'}
 * type are valid.
 *
 * Move all wordpress plugin.php functions to this class 
 * change prefix global variable from "wp_" to "hr_"
 * 
 * @copyright (c) 2006-2012, WordPress
 * @since 1.0.0
 */
class HuradHook {

    /**
     * Stores all of the filters
     * 
     * @var array 
     * @access public
     */
    public static $hr_filter = array();

    /**
     * Merges the filter hooks using this function.
     * 
     * @var array
     * @access public
     */
    public static $merged_filters = array();

    /**
     * stores the list of current filters with the current one last
     * 
     * @var array
     * @access public
     */
    public static $hr_current_filter = array();

    /**
     * Increments the amount of times action was triggered.
     *
     * @var array
     * @access public 
     */
    public static $hr_actions = array();

    /**
     * Hooks a function or method to a specific filter action.
     *
     * Filters are the hooks that Hurad launches to modify text of various types
     * before adding it to the database or sending it to the browser screen. Plugins
     * can specify that one or more of its PHP functions is executed to
     * modify specific types of text at these times, using the Filter API.
     *
     * To use the API, the following code should be used to bind a callback to the
     * filter.
     *
     * <code>
     * function example_hook($example) { echo $example; }
     * add_filter('example_filter', 'example_hook');
     * </code>
     *
     * In Hurad, hooked functions can take extra arguments that are set
     * when the matching do_action() or apply_filters() call is run. The
     * $accepted_args allow for calling functions only when the number of args
     * match. Hooked functions can take extra arguments that are set when the
     * matching do_action() or apply_filters() call is run. For example, the action
     * comment_id_not_found will pass any functions that hook onto it the ID of the
     * requested comment.
     *
     * <strong>Note:</strong> the function will return true no matter if the
     * function was hooked fails or not. There are no checks for whether the
     * function exists beforehand and no checks to whether the <tt>$function_to_add
     * is even a string. It is up to you to take care and this is done for
     * optimization purposes, so everything is as quick as possible.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the filter to hook the $function_to_add to.
     * @param callback $function_to_add The name of the function to be called when the filter is applied.
     * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args optional. The number of arguments the function accept (default 1).
     * @return boolean true
     */
    public static function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
        $idx = self::_hr_filter_build_unique_id($tag, $function_to_add, $priority);
        self::$hr_filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
        unset(self::$merged_filters[$tag]);
        return true;
    }

    /**
     * Check if any filter has been registered for a hook.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the filter hook.
     * @param callback $function_to_check optional.
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     * When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     * When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     * (e.g.) 0, so use the === operator for testing the return value.
     */
    public static function has_filter($tag, $function_to_check = false) {
        $has = !empty(self::$hr_filter[$tag]);
        if (false === $function_to_check || false == $has)
            return $has;

        if (!$idx = self::_hr_filter_build_unique_id($tag, $function_to_check, false))
            return false;

        foreach ((array) array_keys(self::$hr_filter[$tag]) as $priority) {
            if (isset(self::$hr_filter[$tag][$priority][$idx]))
                return $priority;
        }

        return false;
    }

    /**
     * Call the functions added to a filter hook.
     *
     * The callback functions attached to filter hook $tag are invoked by calling
     * this function. This function can be used to create a new filter hook by
     * simply calling this function with the name of the new hook specified using
     * the $tag parameter.
     *
     * The function allows for additional arguments to be added and passed to hooks.
     * <code>
     * function example_hook($string, $arg1, $arg2)
     * {
     * //Do stuff
     * return $string;
     * }
     * $value = apply_filters('example_filter', 'filter me', 'arg1', 'arg2');
     * </code>
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the filter hook.
     * @param mixed $value The value on which the filters hooked to <tt>$tag</tt> are applied on.
     * @param mixed $var,... Additional variables passed to the functions hooked to <tt>$tag</tt>.
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public static function apply_filters($tag, $value) {
        $args = array();

        // Do 'all' actions first
        if (isset(self::$hr_filter['all'])) {
            self::$hr_current_filter[] = $tag;
            $args = func_get_args();
            self::_hr_call_all_hook($args);
        }

        if (!isset(self::$hr_filter[$tag])) {
            if (isset(self::$hr_filter['all']))
                array_pop(self::$hr_current_filter);
            return $value;
        }

        if (!isset(self::$hr_filter['all']))
            self::$hr_current_filter[] = $tag;

        // Sort
        if (!isset(self::$merged_filters[$tag])) {
            ksort(self::$hr_filter[$tag]);
            self::$merged_filters[$tag] = true;
        }

        reset(self::$hr_filter[$tag]);

        if (empty($args))
            $args = func_get_args();

        do {
            foreach ((array) current(self::$hr_filter[$tag]) as $the_)
                if (!is_null($the_['function'])) {
                    $args[1] = $value;
                    $value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $the_['accepted_args']));
                }
        } while (next(self::$hr_filter[$tag]) !== false);

        array_pop(self::$hr_current_filter);

        return $value;
    }

    /**
     * Execute functions hooked on a specific filter hook, specifying arguments in an array.
     *
     * @see apply_filters() This function is identical, but the arguments passed to the
     * functions hooked to <tt>$tag</tt> are supplied using an array.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the filter hook.
     * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public static function apply_filters_ref_array($tag, $args) {
        // Do 'all' actions first
        if (isset(self::$hr_filter['all'])) {
            self::$hr_current_filter[] = $tag;
            $all_args = func_get_args();
            self::_hr_call_all_hook($all_args);
        }

        if (!isset(self::$hr_filter[$tag])) {
            if (isset(self::$hr_filter['all']))
                array_pop(self::$hr_current_filter);
            return $args[0];
        }

        if (!isset(self::$hr_filter['all']))
            self::$hr_current_filter[] = $tag;

        // Sort
        if (!isset(self::$merged_filters[$tag])) {
            ksort(self::$hr_filter[$tag]);
            self::$merged_filters[$tag] = true;
        }

        reset(self::$hr_filter[$tag]);

        do {
            foreach ((array) current(self::$hr_filter[$tag]) as $the_)
                if (!is_null($the_['function']))
                    $args[0] = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
        } while (next(self::$hr_filter[$tag]) !== false);

        array_pop(self::$hr_current_filter);

        return $args[0];
    }

    /**
     * Removes a function from a specified filter hook.
     *
     * This function removes a function attached to a specified filter hook. This
     * method can be used to remove default functions attached to a specific filter
     * hook and possibly replace them with a substitute.
     *
     * To remove a hook, the $function_to_remove and $priority arguments must match
     * when the hook was added. This goes for both filters and actions. No warning
     * will be given on removal failure.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The filter hook to which the function to be removed is hooked.
     * @param callback $function_to_remove The name of the function which should be removed.
     * @param int $priority optional. The priority of the function (default: 10).
     * @param int $accepted_args optional. The number of arguments the function accepts (default: 1).
     * @return boolean Whether the function existed before it was removed.
     */
    public static function remove_filter($tag, $function_to_remove, $priority = 10) {
        $function_to_remove = self::_hr_filter_build_unique_id($tag, $function_to_remove, $priority);

        $r = isset(self::$hr_filter[$tag][$priority][$function_to_remove]);

        if (true === $r) {
            unset(self::$hr_filter[$tag][$priority][$function_to_remove]);
            if (empty(self::$hr_filter[$tag][$priority]))
                unset(self::$hr_filter[$tag][$priority]);
            unset(self::$merged_filters[$tag]);
        }

        return $r;
    }

    /**
     * Remove all of the hooks from a filter.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The filter to remove hooks from.
     * @param int $priority The priority number to remove.
     * @return bool True when finished.
     */
    public static function remove_all_filters($tag, $priority = false) {
        if (isset(self::$hr_filter[$tag])) {
            if (false !== $priority && isset(self::$hr_filter[$tag][$priority]))
                unset(self::$hr_filter[$tag][$priority]);
            else
                unset(self::$hr_filter[$tag]);
        }

        if (isset(self::$merged_filters[$tag]))
            unset(self::$merged_filters[$tag]);

        return true;
    }

    /**
     * Retrieve the name of the current filter or action.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Hook name of the current filter or action.
     */
    public static function current_filter() {
        return end(self::$hr_current_filter);
    }

    /**
     * Hooks a function on to a specific action.
     *
     * Actions are the hooks that the Hurad core launches at specific points
     * during execution, or when specific events occur. Plugins can specify that
     * one or more of its PHP functions are executed at these points, using the
     * Action API.
     *
     * @uses add_filter() Adds an action. Parameter list and functionality are the same.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the action to which the $function_to_add is hooked.
     * @param callback $function_to_add The name of the function you wish to be called.
     * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args optional. The number of arguments the function accept (default 1).
     */
    public static function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
        return self::add_filter($tag, $function_to_add, $priority, $accepted_args);
    }

    /**
     * Execute functions hooked on a specific action hook.
     *
     * This function invokes all functions attached to action hook $tag. It is
     * possible to create new action hooks by simply calling this function,
     * specifying the name of the new hook using the <tt>$tag</tt> parameter.
     *
     * You can pass extra arguments to the hooks, much like you can with
     * apply_filters().
     *
     * @see apply_filters() This function works similar with the exception that
     * nothing is returned and only the functions or methods are called.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the action to be executed.
     * @param mixed $arg,... Optional additional arguments which are passed on to the functions hooked to the action.
     * @return null Will return null if $tag does not exist in $wp_filter array
     */
    public static function do_action($tag, $arg = '') {
        if (!isset(self::$hr_actions))
            self::$hr_actions = array();

        if (!isset(self::$hr_actions[$tag]))
            self::$hr_actions[$tag] = 1;
        else
            ++self::$hr_actions[$tag];

        // Do 'all' actions first
        if (isset(self::$hr_filter['all'])) {
            self::$hr_current_filter[] = $tag;
            $all_args = func_get_args();
            self::_hr_call_all_hook($all_args);
        }

        if (!isset(self::$hr_filter[$tag])) {
            if (isset(self::$hr_filter['all']))
                array_pop(self::$hr_current_filter);
            return;
        }

        if (!isset(self::$hr_filter['all']))
            self::$hr_current_filter[] = $tag;

        $args = array();
        if (is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0])) // array(&$this)
            $args[] = & $arg[0];
        else
            $args[] = $arg;
        for ($a = 2; $a < func_num_args(); $a++)
            $args[] = func_get_arg($a);

        // Sort
        if (!isset(self::$merged_filters[$tag])) {
            ksort(self::$hr_filter[$tag]);
            self::$merged_filters[$tag] = true;
        }

        reset(self::$hr_filter[$tag]);

        do {
            foreach ((array) current(self::$hr_filter[$tag]) as $the_)
                if (!is_null($the_['function']))
                    call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
        } while (next(self::$hr_filter[$tag]) !== false);

        array_pop(self::$hr_current_filter);
    }

    /**
     * Retrieve the number of times an action is fired.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the action hook.
     * @return int The number of times action hook <tt>$tag</tt> is fired
     */
    public static function did_action($tag) {
        if (!isset(self::$hr_actions) || !isset(self::$hr_actions[$tag]))
            return 0;

        return self::$hr_actions[$tag];
    }

    /**
     * Execute functions hooked on a specific action hook, specifying arguments in an array.
     *
     * @see do_action() This function is identical, but the arguments passed to the
     * functions hooked to <tt>$tag</tt> are supplied using an array.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The name of the action to be executed.
     * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
     * @return null Will return null if $tag does not exist in $wp_filter array
     */
    public static function do_action_ref_array($tag, $args) {
        if (!isset(self::$hr_actions))
            self::$hr_actions = array();

        if (!isset(self::$hr_actions[$tag]))
            self::$hr_actions[$tag] = 1;
        else
            ++self::$hr_actions[$tag];

        // Do 'all' actions first
        if (isset(self::$hr_filter['all'])) {
            self::$hr_current_filter[] = $tag;
            $all_args = func_get_args();
            self::_hr_call_all_hook($all_args);
        }

        if (!isset(self::$hr_filter[$tag])) {
            if (isset(self::$hr_filter['all']))
                array_pop(self::$hr_current_filter);
            return;
        }

        if (!isset(self::$hr_filter['all']))
            self::$hr_current_filter[] = $tag;

        // Sort
        if (!isset(self::$merged_filters[$tag])) {
            ksort(self::$hr_filter[$tag]);
            self::$merged_filters[$tag] = true;
        }

        reset(self::$hr_filter[$tag]);

        do {
            foreach ((array) current(self::$hr_filter[$tag]) as $the_)
                if (!is_null($the_['function']))
                    call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
        } while (next(self::$hr_filter[$tag]) !== false);

        array_pop(self::$hr_current_filter);
    }

    /**
     * Check if any action has been registered for a hook.
     *
     * @since 1.0.0
     * @access public
     * @see has_filter() has_action() is an alias of has_filter().
     *
     * @param string $tag The name of the action hook.
     * @param callback $function_to_check optional.
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     * When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     * When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     * (e.g.) 0, so use the === operator for testing the return value.
     */
    public static function has_action($tag, $function_to_check = false) {
        return self::has_filter($tag, $function_to_check);
    }

    /**
     * Removes a function from a specified action hook.
     *
     * This function removes a function attached to a specified action hook. This
     * method can be used to remove default functions attached to a specific filter
     * hook and possibly replace them with a substitute.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The action hook to which the function to be removed is hooked.
     * @param callback $function_to_remove The name of the function which should be removed.
     * @param int $priority optional The priority of the function (default: 10).
     * @return boolean Whether the function is removed.
     */
    public static function remove_action($tag, $function_to_remove, $priority = 10) {
        return self::remove_filter($tag, $function_to_remove, $priority);
    }

    /**
     * Remove all of the hooks from an action.
     *
     * @since 1.0.0
     * @access public
     *
     * @param string $tag The action to remove hooks from.
     * @param int $priority The priority number to remove them from.
     * @return bool True when finished.
     */
    public static function remove_all_actions($tag, $priority = false) {
        return self::remove_all_filters($tag, $priority);
    }

    /**
     * Calls the 'all' hook, which will process the functions hooked into it.
     *
     * The 'all' hook passes all of the arguments or parameters that were used for
     * the hook, which this function was called for.
     *
     * This function is used internally for apply_filters(), do_action(), and
     * do_action_ref_array() and is not meant to be used from outside those
     * functions. This function does not check for the existence of the all hook, so
     * it will fail unless the all hook exists prior to this function call.
     *
     * @since 1.0.0
     * @access private
     *
     * @uses $hr_filter Used to process all of the functions in the 'all' hook
     *
     * @param array $args The collected parameters from the hook that was called.
     * @param string $hook Optional. The hook name that was used to call the 'all' hook.
     */
    private static function _hr_call_all_hook($args) {
        reset(self::$hr_filter['all']);
        do {
            foreach ((array) current(self::$hr_filter['all']) as $the_)
                if (!is_null($the_['function']))
                    call_user_func_array($the_['function'], $args);
        } while (next(self::$hr_filter['all']) !== false);
    }

    /**
     * Build Unique ID for storage and retrieval.
     *
     * The old way to serialize the callback caused issues and this function is the
     * solution. It works by checking for objects and creating an a new property in
     * the class to keep track of the object and new objects of the same class that
     * need to be added.
     *
     * It also allows for the removal of actions and filters for objects after they
     * change class properties. It is possible to include the property $wp_filter_id
     * in your class and set it to "null" or a number to bypass the workaround.
     * However this will prevent you from adding new classes and any new classes
     * will overwrite the previous hook by the same class.
     *
     * Functions and static method callbacks are just returned as strings and
     * shouldn't have any speed penalty.
     *
     * @since 1.0.0
     * @access private
     *
     * @param string $tag Used in counting how many hooks were applied
     * @param callback $function Used for creating unique id
     * @param int|bool $priority Used in counting how many hooks were applied. If === false and $function is an object reference, we return the unique id only if it already has one, false otherwise.
     * @return string|bool Unique ID for usage as array key or false if $priority === false and $function is an object reference, and it does not already have a unique id.
     */
    private static function _hr_filter_build_unique_id($tag, $function, $priority) {
        static $filter_id_count = 0;

        if (is_string($function))
            return $function;

        if (is_object($function)) {
            // Closures are currently implemented as objects
            $function = array($function, '');
        } else {
            $function = (array) $function;
        }

        if (is_object($function[0])) {
            // Object Class Calling
            if (function_exists('spl_object_hash')) {
                return spl_object_hash($function[0]) . $function[1];
            } else {
                $obj_idx = get_class($function[0]) . $function[1];
                if (!isset($function[0]->hr_filter_id)) {
                    if (false === $priority)
                        return false;
                    $obj_idx .= isset(self::$hr_filter[$tag][$priority]) ? count((array) self::$hr_filter[$tag][$priority]) : $filter_id_count;
                    $function[0]->hr_filter_id = $filter_id_count;
                    ++$filter_id_count;
                } else {
                    $obj_idx .= $function[0]->hr_filter_id;
                }

                return $obj_idx;
            }
        } else if (is_string($function[0])) {
            // Static Calling
            return $function[0] . $function[1];
        }
    }

}