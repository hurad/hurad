<?php

/**
 * Description of HuradRowActions
 *
 * @author mohammad
 */
class HuradRowActions
{

    protected static $rows = array();
    protected static $actions = array();

    public static function addActions(
        $row,
        $title,
        $url,
        $capability,
        $linkOptions = array(),
        $confirmMessage = false,
        $actionOptions = null
    ) {
        if (preg_match("/([a-z]+)\[([a-zA-Z_,]+)\]/", $row, $match)) {
            $controller = strtolower($match[1]);
            $actions = strtolower($match[2]);
            $actions = explode(",", $actions);
            foreach ($actions as $action) {
                self::$rows[$controller][$action][] = array(
                    'title' => $title,
                    'url' => $url,
                    'linkOptions' => $linkOptions,
                    'confirmMessage' => $confirmMessage,
                    'actionOptions' => $actionOptions,
                    'capability' => $capability
                );
            }
        }
        Configure::write("Hurad.rowActions", self::$rows);
    }

    public static function addAction($action, $link, $capability, $options = array())
    {
        self::$actions[$action] = array('link' => $link, 'capability' => $capability, 'options' => $options);
    }

    public static function getActions()
    {
        return self::$actions;
    }

}