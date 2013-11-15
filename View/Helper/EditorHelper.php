<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Class EditorHelper
 */
class EditorHelper extends AppHelper
{

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = ['Html', 'Js', 'Hook'];
    /**
     * Textarea name
     *
     * @var string
     */
    protected $name;

    /**
     * Default Constructor
     *
     * @param View $view The View this helper is being attached to.
     * @param array $settings Configuration settings for the helper.
     */
    public function __construct(View $view, $settings = array())
    {
        parent::__construct($view, $settings);
        $this->setName($settings['name']);
    }

    /**
     * Before render callback. beforeRender is called before the view file is rendered.
     *
     * @param string $viewFile The view file that is going to be rendered
     *
     * @return void
     */
    public function beforeRender($viewFile)
    {
        parent::beforeRender($viewFile);
        $this->Html->script('admin/ckeditor/ckeditor.js', ['block' => 'scriptHeader']);
        $this->Html->scriptBlock(
            "window.onload = function() {CKEDITOR.replace('{$this->getName()}'," . $this->Js->object(
                $this->editorConfig()
            ) . ');};',
            ['block' => 'scriptHeader']
        );
    }

    /**
     * Set textarea name
     *
     * @param string $name Textarea name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get textarea name
     *
     * @return string Textarea name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Default config
     *
     * @return mixed
     */
    protected function editorConfig()
    {
        $defaultConfigs = [
            'filebrowserBrowseUrl' => '/admin/media/browse',
            'filebrowserImageBrowseUrl' => '/admin/media/browse/images',
        ];

        return $this->Hook->applyFilters('editor_config', $defaultConfigs, $this->getName());
    }
}
