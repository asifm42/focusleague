<?php

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Helpers\DatabaseSetup;
use Illuminate\Contracts\Debug\ExceptionHandler;

class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseSetup;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl;

    protected function setup()
    {
        parent::setup();
        $this->setupDatabase();
        $this->baseUrl = env('APP_URL', 'http://localhost');
        $this->disableExceptionHandling();
    }

    // Laravel 5.4 - https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da
    // https://adamwathan.me/2016/01/21/disabling-exception-handling/
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }

    // Illuminate\Foundation\Testing\TestResponse
    // "public function dump()"
    // "public function json()" is a shortcut for "public function decodeResponseJson()"
}

