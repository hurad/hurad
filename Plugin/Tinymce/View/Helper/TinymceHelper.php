<?php

App::uses('AppHelper', 'View/Helper');

/**
 * TinymceHelper
 * 
 * @author Fahad Ibnay Heylaal <contact@fahad19.com>
 */
class TinymceHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Js');

    /**
     * Actions
     *
     * Format: ControllerName/action_name => settings
     *
     * @var array
     */
    public $actions = array();

    /**
     * Default settings for tinymce
     *
     * @var array
     * @access public
     */
    public $settings = array(
        // General options
        'mode' => '',
        'selector' => 'textarea.editor',
        'elements' => '',
        'theme' => 'advanced',
        'relative_urls' => false,
        'plugins' => 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,spellchecker,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
        'width' => '100%',
        'height' => '250px',
        // Theme options
        'theme_advanced_buttons1' => 'bold,italic,underline,|,strikethrough,removeformat,|,bullist,numlist,|,outdent,indent,blockquote,|,justifyleft,justifycenter,justifyright,justifyfull,|,ltr,rtl,|,formatselect',
        'theme_advanced_buttons2' => 'forecolor,backcolor,|,pastetext,pasteword,|,charmap,media,|,undo,redo,|,link,unlink,image,cleanup,|,backcolor,|,sub,sup,|,spellchecker,code,|,fullscreen,help',
        //'theme_advanced_buttons3' => 'sub,sup,|,emotions,iespell',
        //'theme_advanced_buttons4' => 'insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
        'theme_advanced_toolbar_location' => 'top',
        'theme_advanced_toolbar_align' => 'left',
        'theme_advanced_statusbar_location' => 'bottom',
        'theme_advanced_resizing' => true,
        // Skin options
        'skin' => 'o2k7',
        'skin_variant' => 'silver',
        // Example content CSS (should be your site CSS)
        //'content_css' => 'css/content.css',
        // Drop lists for link/image/media/template dialogs
        'template_external_list_url' => 'lists/template_list.js',
        'external_link_list_url' => 'lists/link_list.js',
        'external_image_list_url' => 'lists/image_list.js',
        'media_external_list_url' => 'lists/media_list.js',
            // Attachments browser
            //'file_browser_callback' => 'fileBrowserCallBack',
    );

    public function beforeRender($viewFile) {
        parent::beforeRender($viewFile);
        if (is_array(Configure::read('Tinymce.actions'))) {
            $this->actions = Set::merge($this->actions, Configure::read('Tinymce.actions'));
        }
        $action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
        if (isset($this->actions[$action])) {
            echo $this->Html->script('/Tinymce/js/tiny_mce/tiny_mce.js', array('block' => 'headerScript'));
            $settings = $this->getSettings();
            foreach ($settings as $setting) {
                echo $this->Html->scriptBlock('tinyMCE.init(' . $this->Js->object($setting) . ');', array('block' => 'headerScript'));
            }
        }
    }

    /**
     * getSettings
     *
     * @param array $settings
     * @return array
     */
    public function getSettings($settings = array()) {
        $_settings = $this->settings;
        $action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
        if (isset($this->actions[$action])) {
            $settings = array();
            foreach ($this->actions[$action] as $action) {
                $settings[] = Set::merge($_settings, $action);
            }
        }
        return $settings;
    }

}