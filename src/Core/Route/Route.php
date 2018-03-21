<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;
use Core\Route\Exceptions\RoutePatternNotFoundParamException;
use Core\Route\Exceptions\RoutePatternNotValidException;

/**
 * Class Route implementation of RouteInterface
 * @package Core\Route
 */
class Route implements RouteInterface
{
    protected $pattern;

    protected $action;

    protected $prefix = '';

    private $actionArguments = [];

    protected $method;

    protected $middlewares = [];

    private $keyReplaceMatcher = [];

    public function __construct(string $method, $pattern, $action)
    {
        $this->method = $method;
        $this->action = $action;
        $this->pattern = $this->compilePattern($pattern);
    }

    /**
     * Match route pattern with request path
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request): bool
    {
        if ($this->method !== $request ->getMethod()) {
            return false;
        }
        if (!preg_match('/^' . $this->prefix . $this->pattern . '$/', $request->getPath(), $matches)) {
            return false;
        }
        if (!empty($this->keyReplaceMatcher)) {
            foreach ($this->keyReplaceMatcher as $name => $counter) {
                $this->actionArguments[$name] = $matches[$counter];
            }
        }

        return true;
    }

    /**
     * Set prefix for route pattern
     *
     * @param $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = str_replace('/', '\/', $prefix);
    }

    /**
     * add middleware list for route
     *
     * @param array $middlewares
     */
    public function setMiddleware(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function hasMiddlewares(): bool
    {
        return !empty($this->middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * Return simple DTO object for future simple use
     * @return RouteActionInterface
     */
    public function getAction(): RouteActionInterface
    {
        return new RouteAction($this->action, $this->actionArguments);
    }

    /**
     * Format pattern with arguments parsing
     *
     * @param $pattern
     * @return mixed
     */
    private function compilePattern($pattern)
    {
        if (\is_string($pattern)) {
            return $pattern;
        }

        if (!is_array($pattern)) {
            throw new RoutePatternNotValidException('Route given pattern not valid');
        }

        if (count($pattern) !== 2) {
            throw new RoutePatternNotValidException('Route given array pattern values not valid');
        }

        $stringPattern = $pattern[0];
        $patternArguments = $pattern[1];
        $count = 1;
        $keyReplaceMatcher = [];
        $tmpPattern = preg_replace_callback(
            '/{([a-zA-Z]{1}[a-zA-Z-0-9_]*)}/',
            function ($match) use ($patternArguments, &$keyReplaceMatcher, &$count) {
                if (!isset($patternArguments[$match[1]])) {
                    throw new RoutePatternNotFoundParamException('Not found param from route path');
                }
                $keyReplaceMatcher[$match[1]] = $count;
                $count++;
                return '(\\' . $patternArguments[$match[1]] . ')';
            },
            $stringPattern
        );
        $this->keyReplaceMatcher = $keyReplaceMatcher;
        return str_replace('/', '\/', $tmpPattern);
    }
}
