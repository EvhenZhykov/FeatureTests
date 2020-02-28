<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

/**
 * Class LoginTest
 * @package Tests\Feature\Auth
 */
class LoginTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * LoginTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/login';
        $this->email    = 'admin@mail.com';
        $this->password = '123123123';
    }

    /**
     * Check of required fields
     */
    public function testRequiresEmailAndPass()
    {
        $this->response['errors'] = [
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
     * Check of required fields
     */
    public function testRequiresEmail()
    {
        $this->response['errors'] = [
            'password' => [
                "The password field is required."
            ]
        ];
        $data = [
            'email' => $this->email
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check of required fields
     */
    public function testRequiresPass()
    {
        $this->response['errors'] = [
            'email' => [
                "The email field is required."
            ]
        ];
        $data = [
            'password' => $this->password
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check login
     */
    public function testUserLoginSuccessfully()
    {
        $this->response['results'] = [
            'access_token',
            'user' => [
                'id',
                'profile' => [
                    'id',
                    'is_valid'
                ]
            ]
        ];
        $data = [
            'email' => $this->email,
            'password' => $this->password
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check login
     */
    public function testUserLoginFailPass()
    {
        $data = [
            'email' => $this->email,
            'password' => 'random'
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(401)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check login
     */
    public function testUserLoginFailEmail()
    {
        $this->response['errors'] = [
            'email' => [
                "The email must be a valid email address."
            ]
        ];

        $data = [
            'email' => 'random',
            'password' => $this->password
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(400)
            ->assertJson($this->response);
    }

    /**
     * Check login
     */
    public function testUserLoginNotCorrectEmail()
    {
        $data = [
            'email' => 'random@mail.com',
            'password' => $this->password
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(401)
            ->assertJsonStructure($this->response);
    }
}
