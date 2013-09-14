<?php
/**
 * Widgets Controller
 *
 * PHP 5
 *
 * @link http://hurad.org Hurad Project
 * @copyright Copyright (c) 2012-2013, Hurad (http://hurad.org)
 * @package app.Controller
 * @since Version 0.1.0
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */
App::uses('AppController', 'Controller');

/**
 * Class WidgetsController
 */
class WidgetsController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * @var array
     */
    public $uses = array('Option');

    /**
     * Called before the controller action.
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('admin_index', 'admin_edit');
    }

    /**
     * List of widgets
     */
    public function admin_index()
    {
        if ($this->request->is('ajax')) {
            $option_name = Configure::read('template') . '.widgets';
            $widgets_db = unserialize(Configure::read(Configure::read('template') . '.widgets'));
            //Before save sidebar widgets remove exist sidebar data in database.
            foreach (Configure::read('sidebars') as $id => $sidebar) {
                if (array_key_exists($id, $this->request->data)) {
                    unset($widgets_db[$id]);
                }
            }
            $wg = array();
            foreach ($this->request->data as $sidebar_id => $widgets) {
                foreach ($widgets as $widget) {
                    foreach ($widget as $widget_id => $widget_data) {
                        $wg[$sidebar_id][$widget_id] = Hash::combine($widget_data, '{n}.name', '{n}.value');
                    }
                }
            }

            $widgets_order = serialize(Hash::mergeDiff($wg, $widgets_db));
            $this->Option->write($option_name, $widgets_order);
        }
    }

    /**
     * Edit widget
     */
    public function admin_edit()
    {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $optionName = Configure::read('template') . '.widgets';
            $widgetsDB = unserialize(Configure::read($optionName));
            $widgetData = Hash::combine($this->request->data, '{s}.{n}.name', '{s}.{n}.value');
            $newData[$widgetData['unique-id']] = $widgetData;

            foreach ($widgetsDB as $sidebarId => $widgets) {
                foreach ($widgets as $widgetUID => $widget) {
                    if ($widgetUID == $widgetData['unique-id']) {
                        $newArray[$sidebarId][$widgetData['unique-id']] = $widgetData;
                    } else {
                        $newArray[$sidebarId][$widgetUID] = $widget;
                    }
                }
            }

            $widgetUpdated = serialize($newArray);
            $this->Option->write($optionName, $widgetUpdated);
        }
    }

}