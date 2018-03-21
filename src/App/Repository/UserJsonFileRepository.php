<?php

namespace App\Repository;

use App\Entity\User;
use App\Helper\Hydrator;
use Core\App;

class UserJsonFileRepository implements UserRepository
{
    private $filePath;

    private $storage;

    private $hydrator;

    public function __construct(string $filePath)
    {
        if (file_exists($filePath)) {
            $this->storage = json_decode(file_get_contents($filePath), true);
        } else {
            $this->storage = [];
        }

        $this->filePath = $filePath;
        $this->hydrator = App::container()->get(Hydrator::class);
    }

    public function getAll():array
    {
        $data = [];
        if (!empty($this->storage)) {
            foreach ($this->storage as $item) {
                $data[] = $this->hydrator->hydrate(User::class, $item);
            }
        }

        return $data;
    }

    public function save(User $user)
    {
        $this->storage[$user->getId()] = User::toArray($user);

        $this->updateStorage();
    }

    public function remove(User $user)
    {
        unset($this->storage[$user->getId()]);
        $this->updateStorage();
    }

    public function create(User $user)
    {
        $id = $this->nextId();
        $userData = User::toArray($user);
        $userData['id'] = $id;
        $this->storage[$id] = $userData;

        $this->updateStorage();
    }

    public function get($id): User
    {
        if (!isset($this->storage[$id])) {
            throw new \DomainException('User entity not found');
        }

        return $this->hydrator->hydrate(User::class, $this->storage[$id]);
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