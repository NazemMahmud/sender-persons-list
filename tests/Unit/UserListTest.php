<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserListTest extends TestCase
{
    /** Base API URL */
    private string $baseUrl;

    /** Query param for both year and month */
    private string $yearMonthParam;

    /** Query param for year */
    private string $yearParam;

    /** Query param for month */
    private string $monthParam;

    /** Query param for pagination page number (skip data and take from where) */
    private string $paginationPageNumberParam;

    /** number of data to show per page for pagination */
    private int $pageOffset;

    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = 'api/users';
        $this->yearMonthParam = '?year=1969&month=1';
        $this->yearParam ='?year=1969&page=1&pageOffset=20';
        $this->monthParam = '?month=7&page=1&pageOffset=20';
        $this->paginationPageNumberParam = '?year=1969&month=1&page=2&pageOffset=20';
        $this->pageOffset = 20;
    }

    /**
     * Test 1:  check birth month and year parameter without pagination
     * check with: response format, status data value, total data count
     *
     * @return void
     */
    public function test_year_month_param()
    {
        $total = 75; // total number of data count
        $response = $this->get($this->baseUrl . $this->yearMonthParam);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'birthday']
                ],
                'status'
            ])->assertJsonPath('status', 'success')
            ->assertJsonCount($total, 'data');
    }

    /**
     * Test 2:  check only birth month parameter
     *
     * @return void
     */
    public function test_month_param()
    {
        $response = $this->get($this->baseUrl . $this->monthParam);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'birthday']
                ],
                'status'
            ])->assertJsonPath('status', 'success')
            ->assertJsonCount($this->pageOffset, 'data');
    }


    /**
     * Test 3: check only year parameter without pagination
     *
     * @return void
     */
    public function test_year_param()
    {
        $response = $this->get($this->baseUrl . $this->yearParam);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'birthday']
                ],
                'status'
            ])->assertJsonPath('status', 'success')
            ->assertJsonCount($this->pageOffset, 'data');
    }


    /**
     * Test 4:  changing pagination (inc. year and month params)
     *
     * @return void
     */
    public function test_pagination_with_page_number()
    {
        $response = $this->get($this->baseUrl . $this->paginationPageNumberParam);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'birthday']
                ],
                'status'
            ])->assertJsonPath('status', 'success')
            ->assertJsonCount($this->pageOffset, 'data');
    }

}
