<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\User;
use Exception;

class CollectionUsersService implements CollectionUsersServiceInterface
{

    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function ListUsers(): Collection
    {
        $result = $this->user::GetList();

        if (count($result) === 0) {
            throw new Exception('Результатов не обнаружено', 204);
        }

        return $result;
    }


}