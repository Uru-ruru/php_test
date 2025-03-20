<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface CollectionUsersServiceInterface
{
    public function ListUsers(): Collection;
}