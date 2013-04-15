<?php

App::uses('AppController', 'Controller');

/**
 * Description of WidgetsController
 *
 * @author mohammad
 */
class WidgetsController extends AppController {

    public $components = array('RequestHandler');
    public $uses = array('Option');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->Security->unlockedActions = array('admin_index', 'admin_edit');
    }

    public function admin_index() {
        if ($this->RequestHandler->isAjax()) {
            $option_name = Configure::read('template') . '.widgets';
            $widgets_db = unserialize(Configure::read(Configure::read('template') . '.widgets'));
            //Before save sidebar widgets remove exist sidebar data in database.
            foreach (Configure::read('sidebars') as $id => $sidebar) {
                if (key_exists($id, $this->request->data)) {
                    unset($widgets_db[$id]);
                }
            }
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

    public function admin_edit() {
        $this->autoRender = false;

        if ($this->RequestHandler->isAjax()) {
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