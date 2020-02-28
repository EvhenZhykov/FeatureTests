<?php

namespace Tests\Feature\Api;

use App\Models\SpecialDay;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;
use DB;
class SpecialDaysTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * SpecialDaysTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/special_days';

    }

    /**
     * Fill SpecialDays
     */
    public function testFillSpecialDays()
    {
        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'/fill?year=2020&is_whole=1', [], $headers)
            ->assertStatus(201)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get SpecialDays
     */
    public function testGetSpecialDays()
    {
        $this->response['results'] = [
            '*' => [
                'id',
                'date',
                'type',
                'title',
                'is_workday',
            ]
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get SpecialDays by id
     */
    public function testGetSpecialDayByID()
    {
        $this->response['results'] = [
            'id',
            'date',
            'type',
            'title',
            'is_workday',
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        // get special_days
        $specialDays = DB::table('special_days')
            ->where('is_workday', 0)
            ->first();

        $this->json('GET', $this->endpoint."/$specialDays->id", [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }
}
