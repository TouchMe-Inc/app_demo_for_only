<?php

namespace Core\Render\Interface;

interface Renderer
{
    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []): string;
}