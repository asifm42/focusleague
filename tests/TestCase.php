<?php

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Use this version if you're on PHP 7
    // https://gist.github.com/adamwathan/c9752f61102dc056d157
    // https://adamwathan.me/2016/01/21/disabling-exception-handling/
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }

    protected function dieDumpResponseContent()
    {
        $this->dd();
    }

    protected function dd()
    {
        dd($this->response->getContent());
    }
}