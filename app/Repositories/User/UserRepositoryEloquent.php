<?php


namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepositoryEloquent  implements UserRepositoryInterface
{
    /** for raw where condition */
    private string $where = '';

    public function __construct(protected User $model)
    {
    }

    /**
     * Create new multiple resources altogether
     *
     * @param array $data
     * @return mixed
     */
    public function createResource(array $data): mixed
    {
        return $this->model::create($data) ?? false;
    }

    /**
     * Get all / filtered data with country
     *
     * @param array $filterBy
     * @param string $orderBy
     * @param string $sortBy
     * @return array
     */
    public function getAllWithCountry(array $filterBy, string $orderBy = 'DESC', string $sortBy = 'id'): array
    {
        $statement = 'SELECT users.id, users.name, users.email, users.birthday, users.phone, users.ip, countries.name as country_name
                      FROM users
                      INNER JOIN countries
                      ON users.country_id = countries.id';

        if(!empty($filterBy['year'])) {
            $this->setRawWhere("extract(YEAR from users.birthday)=" . $filterBy['year']);
            $statement .= $this->where;
        }

        if(!empty($filterBy['month'])) {
            $this->setRawWhere("extract(MONTH from users.birthday)=" . $filterBy['month']);
            $statement .= $this->where;
        }

        $statement .= " ORDER BY $sortBy $orderBy";

        return DB::select($statement);
    }

    /**
     * For raw sql query set where condition
     *
     * @param string $condition
     * @return void
     */
    private function setRawWhere(string $condition): void
    {
        $this->where = !empty($this->where) ? ' AND ' . $condition : ' WHERE ' . $condition ;
    }

}
