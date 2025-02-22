<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse|RedirectResponse|Response|HttpFoundationResponse
    {
        if ($request->expectsJson()) {
            if ($e instanceof ModelNotFoundException) {
                return response(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
            }
            if ($e instanceof MethodNotAllowedHttpException) {
                return response(['message' => 'Not allowed'], Response::HTTP_METHOD_NOT_ALLOWED);
            }
        }

        return parent::render($request, $e);
    }
}
