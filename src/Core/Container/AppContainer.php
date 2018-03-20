<?php

namespace Core\Container;

class AppContainer
{
    private $storage = [];

    public function set(string $name, \Closure $closure)
    {
        $this->storage[$name] = $closure;
    }

    public function get(string $name)
    {
        if (!isset($this->storage[$name])) {
            throw new ServiceNotFoundException('Service not found in container');
        }

        return $this->storage[$name]($this);
    }
}