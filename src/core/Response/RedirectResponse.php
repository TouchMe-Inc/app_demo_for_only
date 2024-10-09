<?php

namespace Core\Response;

class RedirectResponse extends Response
{

    public function __construct(string $url, int $status = 301, array $headers = []) {
        // TODO: Normalize constructor
        $headers[] = "Location: {$url}";
        parent::__construct('', $status, $headers);
    }
}