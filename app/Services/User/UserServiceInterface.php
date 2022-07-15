<?php

namespace App\Services\User;

interface UserServiceInterface
{
    public function fetchData(array $params): array; // fetch all data from DB

    public function setRedisData(mixed $data, array $params): void; // set data in redis after fetching

    public function getPaginatedDataCollection(mixed $data, array $params): array; // after pagination, get data collection with pagination info
}
