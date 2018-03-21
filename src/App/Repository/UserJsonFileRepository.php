<?php

namespace App\Repository;

use App\Entity\User;

class UserJsonFileRepository implements UserRepository
{
    private $filePath;

    private $storage;

    public function __construct(string $filePath)
    {
        if (file_exists($filePath)) {
            $this->storage = json_decode(file_get_contents($filePath), true);
        } else {
            $this->storage = [];
        }

        $this->filePath = $filePath;
    }

    public function getAll()
    {
        return $this->storage;
    }

    public function save(User $user)
    {
        $this->storage[$user->getId()] = $user->toArray();

        $this->updateStorage();
    }

    public function remove()
    {
        // TODO: Implement remove() method.
    }

    public function create(User $user)
    {
        $id = $this->nextId();
        $userData = $user->toArray();
        $userData['id'] = $id;
        $this->storage[$id] = $userData;

        $this->updateStorage();
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    private function nextId()
    {
        $keys = array_keys($this->storage);
        return !empty($keys) ? max($keys) + 1 : 1;
    }

    private function updateStorage()
    {
        file_put_contents($this->filePath, json_encode($this->storage));
    }
}