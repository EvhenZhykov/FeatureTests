<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

/**
 * Class RegisterTest
 * @package Tests\Feature\Auth
 */
class RegisterTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * RegisterTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/register';
        $this->email    = 'random@mail.com';
        $this->password = '123123123';
        $this->name     = 'Random';
    }

    /**
     * Check of required fields
     */
    public function testRequiresFields()
    {
        $this->response['errors'] = [
            'name' => [
                "The name field is required."
            ],
            'email' => [
                "The email field is required."
            ],
            'password' => [
                "The password field is required."
            ]
        ];

        $this->json('POST', $this->endpoint)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check successfully register
     */
    public function testUserRegisterSuccessfully()
    {
        $this->response['results'] = [
            'user' => [
                'name',
                'email',
                'is_active',
                'profile_id',
                'id'
            ]
        ];
        $data = [
            'name'     => $this->name,
            'email'    => rand().$this->email,
            'password' => $this->password
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(201)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check of required fields
     */
    public function testRequireName()
    {
        $this->response['errors'] = [
            'name' => [
                "The name field is required."
            ]
        ];
        $data = [
            'email'    => $this->email,
            'password' => $this->password,
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check of required fields
     */
    public function testRequireEmail()
    {
        $this->response['errors'] = [
            'email' => [
                "The email field is required."
            ]
        ];
        $data = [
            'name'     => $this->name,
            'password' => $this->password,
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check of required fields
     */
    public function testRequirePassword()
    {
        $this->response['errors'] = [
            'password' => [
                "The password field is required."
            ]
        ];
        $data = [
            'name'  => $this->name,
            'email' => $this->email,
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }
}
