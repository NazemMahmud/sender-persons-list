<?php


namespace App\Repositories\Country;

use App\Models\Country;

class CountryRepositoryEloquent implements CountryRepositoryInterface
{
    public function __construct(protected Country $model)
    {
    }

    /**
     * Create new multiple resources altogether
     *
     * @param array $data
     * @return mixed
     */
    public function createResources(array $data): mixed
    {
        return $this->model::insert($data) ?? false;
    }

    /**
     * get only value from selected column/s of single row
     *
     * @param string $columnName
     * @param string $value
     * @param string|array $selectedColumns IF string type, means only that column value; ELSE array($value => $key) pair
     *
     * @return mixed
     */
    public function pluckByColumn(string $columnName, string $value, string|array $selectedColumns): mixed
    {
        return gettype($selectedColumns) == 'string' ?
            $this->model::where($columnName, $value)->value($selectedColumns) :
            $this->model::where($columnName, $value)->pluck(...$selectedColumns) ;
    }

}
