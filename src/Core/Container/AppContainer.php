<?php

namespace Core\Container;

/**
 * Simple dependency container
 *
 * @package Core\Container
 */
class AppContainer
{
    private $storage = [];

    /**
     * Set dependency
     *
     * @param string $name
     * @param $value
     */
    public function set(string $name, $value)
    {
        $this->storage[$name] = $value;
    }

    /**
     * Get dependency
     *
     * @param string $name
     * @return mixed
     */
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
