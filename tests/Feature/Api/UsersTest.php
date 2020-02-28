<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

/**
 * Class UsersTest
 * @package Tests\Feature\Api
 */
class UsersTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * UsersTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/users';
    }
    /**
     * Get all users
     */
    public function testGetAllUsersSuccessfully()
    {
        $this->response['results'] = [
            'users' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'profile_id',
                    'is_active',
                    'deleted_at',
                    'profile'=>[
                        'id',
                        'user_id',
                        'first_name',
                        'last_name',
                        'phone',
                        'img',
                        'gender',
                        'birthday',
                        'department_id',
                        'department',
                    ],
                    'roles',
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
