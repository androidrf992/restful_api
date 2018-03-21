<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllUsers(): array
    {
        return $this->repository->getAll();
    }

    public function getUser($id): User
    {
        return $this->repository->get($id);
    }

    public function createUser(User $user)
    {
        $this->repository->create($user);
    }

    public function removeUser(User $user)
    {
        $this->repository->remove($user);
    }

    public function saveUser(User $user)
    {
        $this->repository->save($user);
    }
}