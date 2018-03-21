<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepository
{
    public function getAll();

    public function save(User $user);

    public function remove();

    public function create(User $user);

    public function get();
}