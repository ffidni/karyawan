<?php

namespace App\Exceptions;

use App\Http\Resources\Response;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, $exception)
    {
        $response = $this->handleException($request, $exception);
        return $response;
    }

    public function handleException($request, $exception)
    {
        if ($exception instanceof ApiException) {
            return new Response($exception->getStatusCode(), $exception->getMessage(), $exception->getData());
        }
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return new Response(500, $exception->getMessage(), null);
    }


    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}