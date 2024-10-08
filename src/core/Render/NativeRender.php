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
        $level = ob_get_level();

        extract($data, EXTR_SKIP);

        ob_start();

        try {
            require $template;
        } catch (\Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }

        return ob_get_clean();
    }
}