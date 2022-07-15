<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CsvToDbUpload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'csv-to-db';
    }

}
