<?php

namespace App\Services\User;

use App\Helpers\RedisHelper;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\DataTableTrait;

class UsersService implements UserServiceInterface
{
    use DataTableTrait;

    public function __construct(protected UserRepositoryInterface $userRepository)
    {}


    /**
     * Return data collection with pagination info
     *
     * @param mixed $data
     * @param array $params
     * @return array
     */
    public function getPaginatedDataCollection(mixed $data, array $params): array
    {
        $params['page'] = $params['page'] ??  1;
        $response = $this->paginate($data, $params);

        return $this->formatPaginationInfo($response);
    }

    /**
     * Fetch data: for the 1st time from db | query param changed in the API
     *
     * @param array $params
     * @return array
     */
    public function fetchData(array $params): array
    {
        return $this->userRepository->getAllWithCountry($params);
    }

    /**
     * Set redis data when data is fetched from DB
     *
     * @param mixed $data
     * @param array $params
     * @return void
     */
    public function setRedisData(mixed $data, array $params): void
    {
        RedisHelper::setHashData(RedisHelper::HASH_KEY_USERS, [RedisHelper::HASH_KEY_USERS_DATA => json_encode($data)]);
        RedisHelper::setExpire(RedisHelper::HASH_KEY_USERS, RedisHelper::TIME_IN_SECONDS);

        RedisHelper::setData(RedisHelper::KEY_YEAR, $params['year'] ?? ''); // set for year param check
        RedisHelper::setData(RedisHelper::KEY_MONTH, $params['month'] ?? ''); // set for month param check
    }

    /**
     * Is year | month parameter same as before (only for redis data)
     *
     * @param $params
     * @return bool
     */
    public function isYearMonthParamSame($params): bool
    {
        $year = $params['year'] ?? '';
        $month = $params['month'] ?? '';
        $isYearEqual = $year == RedisHelper::getData(RedisHelper::KEY_YEAR);
        $isMonthEqual = $month == RedisHelper::getData(RedisHelper::KEY_MONTH);

        return $isYearEqual && $isMonthEqual;
    }

}
