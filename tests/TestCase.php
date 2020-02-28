<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var array
     */
    protected $response;
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $headers;
    /**
     * TestCase constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->response = [
            'errors' => [],
            'results' => []
        ];
    }
}
