<?php

namespace Core\Http;

class Response
{
    private array $headers;
    private string $content;
    private int $status;

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $this->headers = $headers;
        $this->content = $content;
        $this->status = $status;
    }
}