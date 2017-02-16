<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Carbon;
use Mail;
use Symfony\Component\Debug\ExceptionHandler as SymfonyDisplayer;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->view('errors.custom', [], 500);
        }

        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->view('errors.missingModel', [], 404);
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view('errors.missing', [], 404);
        }

        if ($e instanceof \App\Exceptions\InvalidConfirmationCodeException) {
            // can't flash to the session in exceptions. there is no session.
            // flash()->error('Your confirmation code has expired or is incorrect. Please request a new one to be sent.');

            return redirect()->route('users.resetVerificationCodeForm');
        }

        if ($e instanceof \App\Exceptions\UnauthorizedAccessException
            || $e instanceof \Illuminate\Auth\Access\UnauthorizedException) {
            return response()->view('errors.unauthorizedAccessAttempt', ['msg'=>$e->getMessage()], 403);
        }

        if ($e instanceof \App\Exceptions\SaveModelException) {
            return back()->withInput()->withErrors($e->model->getErrors());
        }

        if ($e instanceof \App\Exceptions\UserVerifiedException) {
            return redirect('signin');
        }

        if ($e instanceof \App\Exceptions\UnverifiedAccountException) {
            return redirect()->route('users.resetVerificationCodeForm', ['error'=>'UnverifiedAccount', 'email'=>$e->user()->email]);
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Convert the given exception into a Response instance.
     *
     * @param \Exception $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        $debug = config('app.debug', false);

        if ($debug) {
            return parent::convertExceptionToResponse($e);
        }

        return response()->view('errors.generic', ['exception' => $e], 500);
    }

    /**
     * Email notification with exception details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \Exception $e
     *
     * @return void
     */
    protected function emailExceptionNotification(Exception $e, $request)
    {

        // Do not send email for NotFoundHttpException
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return;
        }

        $data = [];
        $exception = [];
        $requestArray = [];
        $user = [];

        $exception['class']         = get_class($e);
        $exception['message']       = $e->getMessage();
        $exception['code']          = $e->getCode();
        $exception['line']          = $e->getLine();
        $exception['file']          = $e->getFile();
        $exception['stackTrace']    = $e->getTraceAsString();

        $requestArray['fullUrl']    = $request->fullUrl();
        $requestArray['ips']        = $request->ips();

        if (auth()->check()) {
            $user['id']         = auth()->user()->id;
            $user['name']       = auth()->user()->name;
        }

        $data['exception']      = $exception;
        $data['request']        = $requestArray;
        $data['user']           = $user;
        $data['timeString']     = Carbon::now()->toDayDateTimeString();

        Mail::queue(['text' => 'emails.alert.exception'], $data, function ($message)
        {
            $message->from('exceptionHandler@focusleague.com', 'FOCUS League')
                    ->to('asifm42@gmail.com')
                    ->subject('Exception Occured');
        });
    }
}
