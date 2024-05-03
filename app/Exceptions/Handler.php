<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    // public function render($request, Throwable $exception)
    // {
    //     if ($this->isHttpException($exception) && $exception->getStatusCode() == 404) {
    //         if (Auth::check()) {
    //             return response()->view('errors.auth404', [], 404);
    //         } else {
    //             return response()->view('errors.guest404', [], 404);
    //         }
    //     }

    //     return parent::render($request, $exception);
    // }
}
