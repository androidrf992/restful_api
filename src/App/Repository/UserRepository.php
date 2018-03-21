<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepository
{
    public function getAll(): array;

    public function save(User $user);

    public function remove(User $user);

    public function create(User $user);

    public function get($id): User;
}