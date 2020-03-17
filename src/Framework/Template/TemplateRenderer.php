<?php

namespace Framework\Template;

class TemplateRenderer
{
    private $path;

    public function __construct($path)
    {
        if (!is_dir($path))
            throw new \RuntimeException('Path not found.');
        $this->path = $path;
    }

    public function render($view, array $params = []): string
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}