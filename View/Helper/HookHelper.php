<?php

App::uses('AppHelper', 'View/Helper');

class HookHelper extends AppHelper
{

    /**
     * Hooks a function or method to a specific filter action.
     *
     * Filters are the hooks that WordPress launches to modify text of various types
     * before adding it to the database or sending it to the browser screen. Plugins
     * can specify that one or more of its PHP functions is executed to
     * modify specific types of text at these times, using the Filter API.
     *
     * To use the API, the following code should be used to bind a callback to the
     * filter.
     *
     * <code>
     * function example_hook($example) { echo $example; }
     * $this->Hook->addFilter('example_filter', 'example_hook');
     * </code>
     *
     * In WordPress 1.5.1+, hooked functions can take extra arguments that are set
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
     *
     * @param string $tag The name of the filter to hook the $function_to_add to.
     * @param callback $function_to_add The name of the function to be called when the filter is applied.
     * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args optional. The number of arguments the function accept (default 1).
     *
     * @return boolean true
     */
    public function addFilter($tag, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        HuradHook::add_filter($tag, $function_to_add, $priority, $accepted_args);
    }

    /**
     * Check if any filter has been registered for a hook.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the filter hook.
     * @param callback $function_to_check optional.
     *
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     * When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     * When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     * (e.g.) 0, so use the === operator for testing the return value.
     */
    public function hasFilter($tag, $function_to_check = false)
    {
        HuradHook::has_filter($tag, $function_to_check);
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
     * $value = $this->Hook->applyFilters('example_filter', 'filter me', 'arg1', 'arg2');
     * </code>
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the filter hook.
     * @param mixed $value The value on which the filters hooked to <tt>$tag</tt> are applied on.
     * @param mixed $var,... Additional variables passed to the functions hooked to <tt>$tag</tt>.
     *
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public function applyFilters($tag, $value)
    {
        return HuradHook::apply_filters($tag, $value);
    }

    /**
     * Execute functions hooked on a specific filter hook, specifying arguments in an array.
     *
     * @see applyFilters() This function is identical, but the arguments passed to the
     * functions hooked to <tt>$tag</tt> are supplied using an array.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the filter hook.
     * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
     *
     * @return mixed The filtered value after all hooked functions are applied to it.
     */
    public function applyFiltersRefArray($tag, $args)
    {
        HuradHook::apply_filters_ref_array($tag, $args);
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
     *
     * @param string $tag The filter hook to which the function to be removed is hooked.
     * @param callback $function_to_remove The name of the function which should be removed.
     * @param int $priority optional. The priority of the function (default: 10).
     * @param int $accepted_args optional. The number of arguments the function accepts (default: 1).
     *
     * @return boolean Whether the function existed before it was removed.
     */
    public function removeFilter($tag, $function_to_remove, $priority = 10)
    {
        HuradHook::remove_filter($tag, $function_to_remove, $priority);
    }

    /**
     * Remove all of the hooks from a filter.
     *
     * @since 1.0.0
     *
     * @param string $tag The filter to remove hooks from.
     * @param int $priority The priority number to remove.
     *
     * @return bool True when finished.
     */
    public function removeAllFilters($tag, $priority = false)
    {
        HuradHook::remove_all_filters($tag, $priority);
    }

    /**
     * Retrieve the name of the current filter or action.
     *
     * @since 1.0.0
     *
     * @return string Hook name of the current filter or action.
     */
    public function currentFilter()
    {
        HuradHook::current_filter();
    }

    /**
     * Hooks a function on to a specific action.
     *
     * Actions are the hooks that the WordPress core launches at specific points
     * during execution, or when specific events occur. Plugins can specify that
     * one or more of its PHP functions are executed at these points, using the
     * Action API.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the action to which the $function_to_add is hooked.
     * @param callback $function_to_add The name of the function you wish to be called.
     * @param int $priority optional. Used to specify the order in which the functions associated with a particular action are executed (default: 10). Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
     * @param int $accepted_args optional. The number of arguments the function accept (default 1).
     */
    public function addAction($tag, $function_to_add, $priority = 10, $accepted_args = 1)
    {
        HuradHook::add_action($tag, $function_to_add, $priority, $accepted_args);
    }

    /**
     * Execute functions hooked on a specific action hook.
     *
     * This function invokes all functions attached to action hook $tag. It is
     * possible to create new action hooks by simply calling this function,
     * specifying the name of the new hook using the <tt>$tag</tt> parameter.
     *
     * You can pass extra arguments to the hooks, much like you can with
     * applyFilters().
     *
     * @see applyFilters() This function works similar with the exception that
     * nothing is returned and only the functions or methods are called.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the action to be executed.
     * @param mixed $arg,... Optional additional arguments which are passed on to the functions hooked to the action.
     *
     * @return null Will return null if $tag does not exist in $wp_filter array
     */
    public function doAction($tag, $arg = '')
    {
        return HuradHook::do_action($tag, $arg);
    }

    /**
     * Retrieve the number of times an action is fired.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the action hook.
     *
     * @return int The number of times action hook <tt>$tag</tt> is fired
     */
    public function didAction($tag)
    {
        HuradHook::did_action($tag);
    }

    /**
     * Execute functions hooked on a specific action hook, specifying arguments in an array.
     *
     * @see doAction() This function is identical, but the arguments passed to the
     * functions hooked to <tt>$tag</tt> are supplied using an array.
     *
     * @since 1.0.0
     *
     * @param string $tag The name of the action to be executed.
     * @param array $args The arguments supplied to the functions hooked to <tt>$tag</tt>
     *
     * @return null Will return null if $tag does not exist in $wp_filter array
     */
    public function doActionRefArray($tag, $args)
    {
        HuradHook::do_action_ref_array($tag, $args);
    }

    /**
     * Check if any action has been registered for a hook.
     *
     * @since 1.0.0
     * @see hasFilter() hasAction() is an alias of hasFilter().
     *
     * @param string $tag The name of the action hook.
     * @param callback $function_to_check optional.
     *
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has anything registered.
     * When checking a specific function, the priority of that hook is returned, or false if the function is not attached.
     * When using the $function_to_check argument, this function may return a non-boolean value that evaluates to false
     * (e.g.) 0, so use the === operator for testing the return value.
     */
    function hasAction($tag, $function_to_check = false)
    {
        HuradHook::has_action($tag, $function_to_check);
    }

    /**
     * Removes a function from a specified action hook.
     *
     * This function removes a function attached to a specified action hook. This
     * method can be used to remove default functions attached to a specific filter
     * hook and possibly replace them with a substitute.
     *
     * @since 1.0.0
     *
     * @param string $tag The action hook to which the function to be removed is hooked.
     * @param callback $function_to_remove The name of the function which should be removed.
     * @param int $priority optional The priority of the function (default: 10).
     *
     * @return boolean Whether the function is removed.
     */
    function removeAction($tag, $function_to_remove, $priority = 10)
    {
        HuradHook::remove_action($tag, $function_to_remove, $priority);
    }

    /**
     * Remove all of the hooks from an action.
     *
     * @since 1.0.0
     *
     * @param string $tag The action to remove hooks from.
     * @param int $priority The priority number to remove them from.
     *
     * @return bool True when finished.
     */
    function removeAllActions($tag, $priority = false)
    {
        HuradHook::remove_all_actions($tag, $priority);
    }

}