<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

final class RedisHelper
{
    public const HASH_KEY_USERS = 'users';
    public const HASH_KEY_USERS_DATA = 'data';
    public const KEY_YEAR = 'year';
    public const KEY_MONTH = 'month';
    public const TIME_IN_SECONDS = 60;

    /**
     * Set (HMSET) hashes type data
     *
     * @param string $hashKey
     * @param array|string $data
     * @return void
     */
    public static function setHashData(string $hashKey, array|string $data): void
    {
        foreach ($data as $key => $value) {
            Redis::hmset($hashKey, $key, $value);
        }
    }


    /**
     * Get (HGET) hashes type data
     *
     * @param string $hashKey
     * @param string $key
     * @return mixed
     */
    public static function getHashData(string $hashKey, string $key): mixed
    {
        return Redis::hget($hashKey, $key);
    }

    /**
     * Set expire time for a redis key
     *
     * @param string $key
     * @param int $timeInSeconds
     * @return void
     */
    public static function setExpire(string $key, int $timeInSeconds): void
    {
        Redis::expire($key, $timeInSeconds);
    }

    /**
     * Set string data into redis cache
     *
     * @param string $key
     * @param array|string $value
     * @return void
     */
    public static function setData(string $key, mixed $value): void
    {
        Redis::set($key, $value);
    }

    /**
     * Get string data from redis cache
     *
     * @param string $key
     * @return string
     */
    public static function getData(string $key): string
    {
        return Redis::get($key) ?? '';
    }
}
