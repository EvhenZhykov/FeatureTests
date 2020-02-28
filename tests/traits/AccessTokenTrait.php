<?php


namespace Tests\traits;

use App\User;

/**
 * Class AccessTokenTrait
 * @package Tests\traits
 */
trait AccessTokenTrait
{
    public function getUserToken(){

        /** @var User $user */
        $user = User::find(1);
        return $user->createToken('MyApp')->accessToken;

    }
}
