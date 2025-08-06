<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            // Validación
            if ($exception instanceof ValidationException) {
                return ApiResponse::error(
                    'Error de validación',
                    422,
                    $exception->errors()
                );
            }

            // Modelo no encontrado
            if ($exception instanceof ModelNotFoundException) {
                return ApiResponse::error('Recurso no encontrado', 404);
            }

            // Ruta no encontrada
            if ($exception instanceof NotFoundHttpException) {
                return ApiResponse::error('Ruta no encontrada', 404);
            }

            // No autenticado
            if ($exception instanceof AuthenticationException) {
                return ApiResponse::error('No autenticado', 401);
            }

            // Otro error general
            return ApiResponse::error(
                'Error del servidor',
                500,
                config('app.debug') ? $exception->getMessage() : null
            );
        }

        // Si no es API, se comporta normal (web)
        return parent::render($request, $exception);
    }
}
