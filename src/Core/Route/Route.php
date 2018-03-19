<?php

namespace Core\Route;

use Core\Http\Request\RequestInterface;
use Core\Route\Exceptions\RoutePatternNotFoundParamException;

class Route implements RouteInterface
{
    protected $pattern;

    protected $action;

    protected $filteredParams = [];

    protected $paramRules;

    protected $method;

    private $keyReplaceMatcher;

    public function __construct(string $method, string $pattern, $action, $paramRules = [])
    {
        $this->method = $method;
        $this->action = $action;
        $this->pattern = $pattern;
        $this->paramRules = $paramRules;
    }

    public function match(RequestInterface $request): bool
    {
        if ($this->method !== $request ->getMethod()) {
            return false;
        }

        $compiledPattern = $this->compilePattern();
        if (!preg_match('/^' . $compiledPattern . '$/', $request->getUri(), $matches)) {
            return false;
        }

        if (!empty($this->keyReplaceMatcher)) {
            foreach ($this->keyReplaceMatcher as $name => $counter) {
                $this->filteredParams[$name] = $matches[$counter];
            }
        }

        return true;
    }

    private function compilePattern()
    {
        $count = 1;
        $keyReplaceMatcher = [];
        $params = $this->paramRules;
        $tmpPattern = preg_replace_callback(
            '/{([a-zA-Z]{1}[a-zA-Z-0-9_]*)}/',
            function ($match) use ($params, &$keyReplaceMatcher, &$count) {
                if (!isset($params[$match[1]])) {
                    throw new RoutePatternNotFoundParamException('Not found param from route path');
                }
                $keyReplaceMatcher[$match[1]] = $count;
                $count++;
                return '(\\' . $params[$match[1]] . ')';
            },
            $this->pattern
        );
        $this->keyReplaceMatcher = $keyReplaceMatcher;
        return str_replace('/', '\/', $tmpPattern);
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams(): array
    {
        return $this->filteredParams;
    }
}