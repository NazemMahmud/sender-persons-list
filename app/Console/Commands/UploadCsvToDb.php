<?php

namespace App\Console\Commands;

use App\Facades\CsvToDbUpload;
use Illuminate\Console\Command;

class UploadCsvToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:csvtodb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload data from csv to db tables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CsvToDbUpload::populateDb();
    }
}
