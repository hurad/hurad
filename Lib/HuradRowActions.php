<?php

/**
 * Description of HuradRowActions
 *
 * @todo Complete phpDoc
 */
class HuradRowActions
{

    protected static $rows = array();
    protected static $actions = array();

    public static function addAction($action, $link, $capability, $options = array())
    {
        self::$actions[$action] = array('link' => $link, 'capability' => $capability, 'options' => $options);
    }

    public static function getActions()
    {
        return self::$actions;
    }

}