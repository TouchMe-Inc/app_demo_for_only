<?php

namespace Core\Request;

class Request
{
    public const METHOD_HEAD = 'HEAD';
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_OPTIONS = 'OPTIONS';

    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $uri;

    private string $content;

    private RequestParameters $get;
    private RequestParameters $post;
    private RequestParameters $server;
    private RequestParameters $cookies;
    private RequestParameters $files;


    /**
     * @param array $get
     * @param array $post
     * @param array $server
     * @param array $cookies
     * @param array $files
     */
    public function __construct(array $get = [], array $post = [], array $server = [], array $cookies = [], array $files = [])
    {
        $this->get = new RequestParameters($get);
        $this->post = new RequestParameters($post);
        $this->server = new RequestParameters($server);
        $this->cookies = new RequestParameters($cookies);
        $this->files = new RequestParameters($files);

        $this->method = $server['REQUEST_METHOD'];
        $this->uri = $this->prepareUri($server['REQUEST_URI']);;
    }

    /**
     * @return static
     */
    public static function createFromGlobal(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    private function prepareUri(string $uri): string
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        return $uri;
    }

    /**
     * So... getGet!
     */
    public function getGet(): RequestParameters
    {
        return $this->get;
    }

    public function getPost(): RequestParameters
    {
        return $this->post;
    }

    public function getServer(): RequestParameters
    {
        return $this->server;
    }

    public function getCookies(): RequestParameters
    {
        return $this->cookies;
    }

    public function getFiles(): RequestParameters
    {
        return $this->files;
    }
}