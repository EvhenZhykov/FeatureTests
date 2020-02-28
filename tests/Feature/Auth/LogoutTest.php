<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

/**
 * Class LogoutTest
 * @package Tests\Feature\Auth
 */
class LogoutTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * LogoutTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/logout';

    }

    /**
     * Test Success logout
     *
     * @return void
     */
    public function testSuccessLogout()
    {
        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', $this->endpoint, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Test Fail logout
     *
     * @return void
     */
    public function testFailLogout()
    {
        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token.'random'"];

        $this->json('GET', $this->endpoint, [], $headers)
            ->assertStatus(401)
            ->assertJsonStructure($this->response);
    }
}
