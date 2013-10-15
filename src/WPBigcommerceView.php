<?php

class WPBigcommerceView
{
    private $template;
    private $data;
    private $templatePath;
    private $templateExt;

    public function __construct($template, $data = array(), $templatePath = '', $templateExt = '')
    {
        $this->template = $template;
        $this->data = $data;
        $this->templatePath = $templatePath;
        $this->templateExt = $templateExt;

        if ($this->templatePath === '') $this->templatePath = dirname(__FILE__) . '/../assets/templates/';
        if ($this->templateExt === '') $this->templateExt = '.html.php';
    }

    public function getFullTemplatePath()
    {
        return $this->templatePath . $this->template . $this->templateExt;
    }

    public function render()
    {
        ob_start();
        extract($this->data);
        include($this->getFullTemplatePath());
        return ob_get_clean();
    }
}