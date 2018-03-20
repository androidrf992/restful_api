<?php

namespace Core\Container;

class AppContainer
{
    private $storage = [];

    public function set(string $name, $value)
    {
        $this->storage[$name] = $value;
    }

    public function get(string $name)
    {
        if (!isset($this->storage[$name])) {
            throw new ServiceNotFoundException('Service not found in container');
        }

        if ($this->storage[$name] instanceof \Closure) {
            return $this->storage[$name]($this);
        }

        return $this->storage[$name];
    }
}
