<?php

namespace Core\Render;

use Core\Render\Interface\Renderer;
use Exception;

class NativeRender implements Renderer
{
    /**
     * @throws Exception
     */
    public function render(string $template, array $data = []): string
    {
        if (!file_exists($template)) {
            throw new Exception("Template '$template' does not exist.");
        }

        extract($data, EXTR_SKIP);

        ob_start();

        try {
            require $template;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }
}