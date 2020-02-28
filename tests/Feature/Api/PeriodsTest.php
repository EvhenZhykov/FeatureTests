<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

class PeriodsTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * PeriodsTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/periods';

    }

    /**
     * Get Periods
     */
    public function testGetPeriodsSuccessfully()
    {
        $this->response['results'] = [
            'periods'
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?from=2019-01-01&to=2020-01-31&user_id=1&department_id=3&day_type_id=3', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodsWithoutFromParam()
    {
        $this->response['errors'] = [
            'from' => [
                "The from field is required when to is present."
            ],
            'to' => [
                "The to must be a date after or equal to from."
            ]
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?to=2020-01-31&user_id=1&department_id=3&day_type_id=3', [], $headers)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodsWithoutToParam()
    {
        $this->response['errors'] = [
            'to' => [
                "The to field is required when from is present."
            ]
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?from=2019-01-01&user_id=1&department_id=3&day_type_id=3', [], $headers)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodsWithoutUserIDParam()
    {
        $this->response['results'] = [
            'periods'
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?from=2019-01-01&to=2020-01-31&department_id=3&day_type_id=3', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodsWithoutDepartmentIDParam()
    {
        $this->response['results'] = [
            'periods'
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?from=2019-01-01&to=2020-01-31&user_id=1&day_type_id=3', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodsWithoutDayTypeIDParam()
    {
        $this->response['results'] = [
            'periods'
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'?from=2019-01-01&to=2020-01-31&user_id=1&department_id=3', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodByID()
    {
        $this->response['results'] = [[
            'id',
            'user_id',
            'description',
            'first_date',
            'last_date',
            'day_type_id',
        ]];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'/1', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Get Periods
     */
    public function testGetPeriodByIDFail()
    {
        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint.'/0', [], $headers)
            ->assertStatus(404)
            ->assertJsonStructure($this->response);
    }
}
