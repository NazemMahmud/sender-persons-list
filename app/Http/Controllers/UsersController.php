<?php

namespace App\Http\Controllers;

use App\Helpers\HttpHandler;
use App\Helpers\RedisHelper;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserServiceInterface $userService
    )
    {}

    /**
     * Get all / filtered users data
     * Check in redis first: 1. params unchanged, 2. 60secs time period
     * filter params: year | month
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $params = $request->all();
        $cachedData = RedisHelper::getHashData(RedisHelper::HASH_KEY_USERS, RedisHelper::HASH_KEY_USERS_DATA);

        if ( $cachedData && $this->userService->isYearMonthParamSame($params) ) {
            $response = json_decode($cachedData);
        } else {
            $response = $this->userService->fetchData($params);
            $this->userService->setRedisData($response, $params);
        }

        return !empty($params['pageOffset']) ? $this->userService->getPaginatedDataCollection($response, $params)
               : HttpHandler::successResponse($response);
    }

}
