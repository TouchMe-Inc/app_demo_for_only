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

    private ParameterStorage $get;
    private ParameterStorage $post;
    private ParameterStorage $server;
    private ParameterStorage $cookies;
    private ParameterStorage $files;


    /**
     * @param array $get
     * @param array $post
     * @param array $server
     * @param array $cookies
     * @param array $files
     */
    public function __construct(array $get = [], array $post = [], array $server = [], array $cookies = [], array $files = [])
    {
        $this->get = new ParameterStorage($get);
        $this->post = new ParameterStorage($post);
        $this->server = new ParameterStorage($server);
        $this->cookies = new ParameterStorage($cookies);
        $this->files = new ParameterStorage($files);

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
    public function getGet(): ParameterStorage
    {
        return $this->get;
    }

    public function getPost(): ParameterStorage
    {
        return $this->post;
    }

    public function getServer(): ParameterStorage
    {
        return $this->server;
    }

    public function getCookies(): ParameterStorage
    {
        return $this->cookies;
    }

    public function getFiles(): ParameterStorage
    {
        return $this->files;
    }
}