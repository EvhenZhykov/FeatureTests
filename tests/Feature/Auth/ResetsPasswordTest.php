<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;
use DB;

/**
 * Class ResetsPasswordTest
 * @package Tests\Feature\Auth
 */
class ResetsPasswordTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * ResetsPasswordTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/resetpass';
        $this->email    = 'admin@mail.com';
        $this->password = '234234234';
    }

    /**
     * Check reset successfully
     */
    public function testResetSuccessfully()
    {
        $data = [
            'redirect_url' => "http://localhost:4200/reset",
            'email'    => $this->email
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(204);
    }

    /**
     * Check reset fail
     */
    public function testResetFail()
    {
        $data = [
            'redirect_url' => "http://localhost:4200/reset",
            'email'    => $this->email.'random'
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(404)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check set reset password successfully
     */
    public function testSetResetPasswordSuccessfully()
    {
        $token = DB::table('password_resets')
            ->where('email', $this->email)
            ->first();

        $data = [
            'redirect_url' => "http://localhost:4200/login",
            'reset_token'  => $token->token,
            'password'     => $this->password
        ];
        $this->json('POST', 'api/setpassword', $data)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check set reset password fail
     */
    public function testSetResetPasswordFail()
    {
        $data = [
            'redirect_url' => "http://localhost:4200/login",
            'reset_token'  => 'random',
            'password'     => $this->password
        ];
        $this->json('POST', 'api/setpassword', $data)
            ->assertStatus(404)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check reset successfully
     */
    public function testResetSuccessfully2()
    {
        $data = [
            'redirect_url' => "http://localhost:4200/reset",
            'email'    => $this->email
        ];
        $this->json('POST', $this->endpoint, $data)
            ->assertStatus(204);
    }

    /**
     * Check set reset password successfully
     */
    public function testSetResetPasswordSuccessfully2()
    {
        $token = DB::table('password_resets')
            ->where('email', $this->email)
            ->first();

        $data = [
            'redirect_url' => "http://localhost:4200/login",
            'reset_token'  => $token->token,
            'password'     => '123123123'
        ];
        $this->json('POST', 'api/setpassword', $data)
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }
}
