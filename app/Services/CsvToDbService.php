<?php

namespace App\Services;

use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class CsvToDbService
{
    /** total columns in CSV file */
    private int $totalColumns = 0;

    /** all csv rows into data array */
    private array $csvData = [];

    /**  Only for countries */
    private array $countries = [];

    public function __construct(
        protected CountryRepositoryInterface $countryRepository,
        protected UserRepositoryInterface    $userRepository,
    )
    {

    }

    /**
     * Main / Starting function to call for facade
     *
     * @return void
     */
    public function populateDb(): void
    {
        $filePath = env("CSV_FILE_PATH");
        if (!file_exists($filePath)) {
            echo "File Not exists...";
            return;
        }
        $this->setDataFromCSV($filePath);

        if ($this->insertCountryData()) {
            $this->insertUserData();
        }
    }

    /**
     * Read each line from CSV and to set into data array
     *
     * @param string $filePath
     * @return void
     */
    private function setDataFromCSV(string $filePath): void
    {
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
                // ignore empty lines, there are 2 blank lines at the bottom of the csv
                if (array_filter($data)) {
                    $this->totalColumns = count($data);
                    $this->csvData[] = $data;
                    $this->countries[] = $data[$this->totalColumns - 1];
                }
            }

            fclose($handle);
        }

        $this->formatCountryData();
    }

    /**
     * From country array data:
     * Unset the 1st index, because it contains CSV column name
     * Map the array to ensure bulk insertion with timestamps
     *
     * @return void
     */
    private function formatCountryData(): void
    {
        unset($this->countries[0]);
        $now = date('Y-m-d H:i:s');
        $this->countries = array_map(function ($v) use ($now) {
            return [
                'name' => $v,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }, array_unique($this->countries));
    }

    /**
     * Insert countries data into corresponding table
     *
     * @return bool
     */
    private function insertCountryData(): bool
    {
        if (!$this->countryRepository->createResources($this->countries)) {
            echo 'Country Insertion problem occurs..';
            return false;
        }
        return true;
    }

    /**
     * Insert countries data into corresponding table
     *
     * @return void
     */
    private function insertUserData(): void
    {
        unset($this->csvData[0]);
        foreach ($this->csvData as $item) {
            $user = [
                'name' => $item[2],
                'email' => $item[1],
                'birthday' => $item[3],
                'phone' => $item[4],
                'ip' => $item[5],
                'country_id' =>  $this->countryRepository->pluckByColumn('name', $item[$this->totalColumns - 1], 'id'),
            ];

            if (!$this->userRepository->createResource($user)) {
                echo 'User Insertion problem occurs..';
                return;
            }
        }

        echo "\n Uploading to DB done..";
    }
}
