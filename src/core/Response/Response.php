<?php

namespace Core\Response;

class Response
{
    private array $headers;
    private string $content;
    private int $status;

    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->headers = $headers;
        $this->content = $content;
        $this->status = $status;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }

        http_response_code($this->status);
    }

    private function sendContent(): void
    {
        echo $this->content;
    }
}