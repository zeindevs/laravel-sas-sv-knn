<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
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

        $this->renderable(function (Throwable $e, Request $request) {

            if ($request->is("api/*")) {
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], Response::HTTP_UNAUTHORIZED);
                }

                if ($e instanceof UnauthorizedException) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], Response::HTTP_UNAUTHORIZED);
                }
            }
        });
    }
}
