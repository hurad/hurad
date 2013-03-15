<?php

class EditorHelper extends AppHelper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Js', 'Hook');
    public $defaults = array(
        // General options
        'mode' => '',
        'selector' => 'textarea.editor',
        'elements' => '',
        'theme' => 'advanced',
        'relative_urls' => false,
        'plugins' => 'safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,spellchecker,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
        'width' => '100%',
        'height' => '250px',
        'theme_advanced_toolbar_location' => 'top',
        'theme_advanced_toolbar_align' => 'left',
        'theme_advanced_statusbar_location' => 'bottom',
        'theme_advanced_resizing' => true,
        // Skin options
        'skin' => 'o2k7',
        'skin_variant' => 'silver',
    );

    public function beforeRender($viewFile) {
        parent::beforeRender($viewFile);
        $this->Html->script('admin/tiny_mce/tiny_mce.js', array('block' => 'headerScript'));
        $this->Html->scriptBlock('tinyMCE.init(' . $this->Js->object($this->editorSettings()) . ');', array('block' => 'headerScript'));
    }

    public function editorSettings() {
        $theme_buttons1 = $this->Hook->applyFilters('tiny_theme_buttons1', array(
            array('bold', 'italic', 'underline'),
            array('strikethrough', 'removeformat'),
            array('bullist', 'numlist'),
            array('outdent', 'indent', 'blockquote'),
            array('justifyleft', 'justifycenter', 'justifyright', 'justifyfull'),
            array('ltr', 'rtl'),
            array('formatselect'),
                )
        );

        foreach ($theme_buttons1 as $key => $value) {
            $buttons1[] = implode(',', $value);
        }

        $theme_buttons2 = $this->Hook->applyFilters('tiny_theme_buttons2', array(
            array('forecolor', 'backcolor'),
            array('pastetext', 'pasteword'),
            array('charmap', 'media'),
            array('undo', 'redo'),
            array('link', 'unlink', 'image', 'cleanup'),
            array('backcolor'),
            array('sub', 'sup'),
            array('spellchecker', 'code'),
            array('fullscreen', 'help'),
                )
        );

        foreach ($theme_buttons2 as $key => $value) {
            $buttons2[] = implode(',', $value);
        }

        $tinyMceInit = array(
            'theme_advanced_buttons1' => implode(',|,', $buttons1),
            'theme_advanced_buttons2' => implode(',|,', $buttons2),
        );

        return $this->Hook->applyFilters('tiny_mce_init', Set::merge($tinyMceInit, $this->defaults));
    }

}