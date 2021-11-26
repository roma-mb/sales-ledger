<?php

namespace App\Exceptions;

use App\Enumerations\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /** @var string[] */
    protected $dontReport = [
    ];

    /** @var string[] */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(static function (NotFoundHttpException $exception, $request) {
            return response()->json([
                'shortMessage' => Exceptions::NOT_FOUND,
                'message' => Lang::get('exceptions.' . Exceptions::NOT_FOUND),
                'httpCode' => Response::HTTP_NOT_FOUND,
                'description' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        });

        $this->reportable(function (Throwable $e) {
        });
    }
}
