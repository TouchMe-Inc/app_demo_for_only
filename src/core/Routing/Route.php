<?php

namespace Core\Routing;

use Closure;
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
     * @var mixed
     */
    private Closure|array $handler;

    /**
     * Create route instance.
     *
     * @param string $method
     * @param string $uri
     * @param mixed $handler
     */
    public function __construct(string $method, string $uri, Closure|array $handler)
    {
        $this->setMethod($method);

        list($regex, $variableNames) = $this->parseUri($uri);

        $this->regex = $regex;

        $this->variableNames = $variableNames;

        $this->handler = $handler;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = strtoupper($method);
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
     * @return Closure|array
     */
    public function getHandler(): Closure|array
    {
        return $this->handler;
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
     */
    private function parseUri(string $uri): array
    {
        $variableNames = [];

        if (preg_match_all("~\{\s* ([a-zA-Z0-9_]*) \s*(?:: \s* ([^{]+(?:\{.*?})?))?}\??~x", $uri, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER) === 0) {
            return ["~^{$uri}\$~", $variableNames];
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

            $variableNames[] = $set[1][0];

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

        return ["~^" . implode('', $regex) . "$^", $variableNames];
    }
}