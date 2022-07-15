<?php

namespace App\Repositories\Country;


interface CountryRepositoryInterface
{
    public function createResources(array $data): mixed; // create new multiple resources altogether

    public function pluckByColumn(string $columnName, string $value, string|array $selectedColumns): mixed; // get selected column/s from single row
}
