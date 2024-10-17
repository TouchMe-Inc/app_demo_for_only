<?php

namespace Core\Request;

use Core\Request\Interface\Request as RequestInterface;
use Core\Session\interface\Session as SessionInterface;

class Request implements RequestInterface
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


    private ParameterStorage $query;
    private ParameterStorage $post;
    private ParameterStorage $server;
    private ParameterStorage $cookies;
    private ParameterStorage $files;

    private SessionInterface|null $session;

    /**
     * @param array $get
     * @param array $post
     * @param array $server
     * @param array $cookies
     * @param array $files
     */
    public function __construct(array $get = [], array $post = [], array $server = [], array $cookies = [], array $files = [])
    {
        $this->query = new ParameterStorage($get);
        $this->post = new ParameterStorage($post);
        $this->server = new ParameterStorage($server);
        $this->cookies = new ParameterStorage($cookies);
        $this->files = new ParameterStorage($files);

        $this->method = $this->server->get('REQUEST_METHOD', Request::METHOD_GET);
        $this->uri = $this->prepareUri($this->server->get('REQUEST_URI', '/'));
        $this->session = null;
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
        // ?: Who are you? Duplicate?
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        // #: I am you, only better
        if (str_contains($uri, '#')) {
            $uri = substr($uri, 0, strpos($uri, '#'));
        }

        return $uri;
    }

    public function getQuery(): ParameterStorage
    {
        return $this->query;
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

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function setSession(SessionInterface $session): void
    {
        $this->session = $session;
    }

    public function hasSession(): bool
    {
        return $this->session != null;
    }
}