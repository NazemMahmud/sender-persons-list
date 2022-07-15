<?php

namespace App\Repositories\User;


interface UserRepositoryInterface
{
    public function createResource(array $data): mixed; // create new resource

    public function getAll(array $filterBy, string $orderBy, string $sortBy): array; // get all / filtered data
}
