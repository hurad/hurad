<?php
/**
 * Widgets Controller
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
App::uses('AppController', 'Controller');

/**
 * Class WidgetsController
 */
class WidgetsController extends AppController
{
    /**
     * An array containing the class names of models this controller uses.
     *
     * Example: `public $uses = array('Product', 'Post', 'Comment');`
     *
     * Can be set to several values to express different options:
     *
     * - `true` Use the default inflected model name.
     * - `array()` Use only models defined in the parent class.
     * - `false` Use no models at all, do not merge with parent class either.
     * - `array('Post', 'Comment')` Use only the Post and Comment models. Models
     *   Will also be merged with the parent class.
     *
     * The default value is `true`.
     *
     * @var mixed A single name as a string or a list of names as an array.
     * @link http://book.cakephp.org/2.0/en/controllers.html#components-helpers-and-uses
     */
    public $uses = ['Option'];

    /**
     * Called before the controller action. You can use this method to configure and customize components
     * or perform logic that needs to happen before each controller action.
     *
     * @return void
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
