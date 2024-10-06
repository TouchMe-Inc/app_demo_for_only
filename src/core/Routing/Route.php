<?php

namespace Core\Routing;

use Exception;

class Route
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $regex;

    /**
     * @var array
     */
    private array $variableNames;

    /**
     * @var callable
     */
    private $callable;


    /**
     * @param $method
     * @param $uri
     * @param $handler
     * @throws Exception
     */
    public function __construct($method, $uri, $handler)
    {
        $this->method = $method;

        list($regex, $variableNames) = $this->parseUri($uri);

        $this->regex = '~^' . $regex . '$~';

        $this->variableNames = $variableNames;

        $this->callable = $this->parseHandler($handler);
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
    public function getRegex(): string
    {
        return $this->regex;
    }

    /**
     * @return array
     */
    public function getVariableNames(): array
    {
        return $this->variableNames;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * @param $method
     * @return bool
     */
    public function compareMethod($method): bool
    {
        return $this->method === $method;
    }

    /**
     * @param string $uri
     * @return bool
     */
    public function compareUri(string $uri): bool
    {
        if (preg_match($this->getRegex(), $uri) !== 1) {
            return false;
        }

        return true;
    }

    /**
     * @param string $uri
     * @return array
     * @throws Exception
     */
    private function parseUri(string $uri): array
    {
        $variableNames = [];

        if (preg_match_all("~\{\s* ([a-zA-Z0-9_]*) \s*(?:: \s* ([^{]+(?:\{.*?})?))?}\??~x", $uri, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER) === 0) {
            return [$uri, $variableNames];
        }

        $regex = [];

        $lastOffset = 0;

        foreach ($matches as $set) {
            $offset = (int)$set[0][1];

            foreach (preg_split('~(/)~u', substr($uri, $lastOffset, $offset - $lastOffset), 0, PREG_SPLIT_DELIM_CAPTURE) as $static) {
                if ($static) {
                    $regex[] = $static;
                }
            }

            $variable = $set[1][0];

            if (in_array($variable, $variableNames)) {
                throw new Exception("Variable '{$variable}' already defined.");
            }

            $variableNames[] = $variable;

            $regexPart = (isset($set[2]) ? trim($set[2][0]) : '[^/]+');

            $regex[] = '(' . $regexPart . ')';

            $lastOffset = $offset + strlen($set[0][0]);
        }

        $templateLength = strlen($uri);

        if ($lastOffset < $templateLength) {
            foreach (preg_split('~(/)~u', substr($uri, $lastOffset, $templateLength - $lastOffset), 0, PREG_SPLIT_DELIM_CAPTURE) as $static) {
                if ($static) {
                    $regex[] = $static;
                }
            }
        }

        return [implode('', $regex), $variableNames];
    }

    /**
     * @param mixed $handler
     * @return callable
     * @throws Exception
     */
    private function parseHandler(mixed $handler): callable
    {
        if (is_array($handler) && is_string($handler[0])) {
            $handler[0] = new $handler[0];
        }

        if (is_callable($handler)) {
            return $handler;
        }

        throw new Exception("Handler '$handler' does not exist.");
    }
}