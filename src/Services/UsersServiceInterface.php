<?php

namespace App\Services;

use App\Models\User;

interface UsersServiceInterface
{
    public function setUser(User $user): self;

    public function getUser(): User;

    public function createUser($id): self;
}