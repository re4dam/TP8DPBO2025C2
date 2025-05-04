<?php
class Template
{
    private $template;
    private $content;

    public function __construct($template_file)
    {
        if (file_exists($template_file)) {
            $this->template = $template_file;
            $this->content = file_get_contents($template_file);
        } else {
            die("Template file not found: $template_file");
        }
    }

    public function replace($placeholder, $replacement)
    {
        $this->content = str_replace($placeholder, $replacement, $this->content);
    }

    public function write()
    {
        echo $this->content;
    }
}
