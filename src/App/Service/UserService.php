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

    public function createUser(User $user)
    {
        $this->repository->create($user);
    }
}