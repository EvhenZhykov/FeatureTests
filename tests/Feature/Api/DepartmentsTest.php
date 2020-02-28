<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

class DepartmentsTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * DepartmentsTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/departments';

    }

    /**
     * Test get departments fail
     */
    public function testGetDepartmentsFail()
    {
        $headers = ['Authorization' => "Bearer random"];
        $this->json('GET', $this->endpoint, [], $headers)
            ->assertStatus(401)
            ->assertJson($this->response);
    }

    /**
     * Test get departments fail
     */
    public function testGetDepartmentsSuccessfully()
    {
        $this->response['results'] = [
            'departments' => [
                '*' => [
                    'id',
                    'title',
                    'description'
                ]
            ]
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];
        $this->json('GET', $this->endpoint, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }
}
