<?php

namespace Tests\Feature\Api;

use App\Models\Invite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\traits\AccessTokenTrait;

/**
 * Class InviteTest
 * @package Tests\Feature\Auth
 */
class InviteTest extends TestCase
{
    use AccessTokenTrait;

    /**
     * InviteTest constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->endpoint = 'api/invites';
        $this->email    = 'evhenzhykov@gmail.com';
        $this->host     = 'localhost';

    }

    /**
     * Check of required fields
     */
    public function testInviteWithoutAccessToken()
    {
        $this->json('POST', $this->endpoint)
            ->assertStatus(401)
            ->assertJson($this->response);
    }

    /**
     * Check create invite
     */
    public function testCreateInvite()
    {
        $this->response['results'] = [
            'invite' => [
                'email',
                'host',
                'invite_token'
            ]
        ];

        $token = $this->getUserToken();
        $headers = ['Authorization' => "Bearer $token"];

        $data = ['email' => $this->email, 'host' => $this->host];
        $this->json('POST', $this->endpoint, $data, $headers)
            ->assertStatus(201)
            ->assertJsonStructure($this->response);
    }

    /**
     * Check create invite
     */
    public function testGetInviteByToken()
    {
        $this->response['results'] = [
            'invite' => [
                'id',
                'email',
                'invite_token'
            ]
        ];

        $invite = Invite::where('email', '=', $this->email)->first();

        $this->json('GET', $this->endpoint."?invite_token= $invite->invite_token")
            ->assertStatus(200)
            ->assertJsonStructure($this->response);
    }
}
