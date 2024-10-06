<?php

namespace Core\Render;

use Core\Render\Interface\Renderer;

class DummyRender implements Renderer
{
    public function render(string $template, array $data = []): string
    {
        return $template;
    }
}