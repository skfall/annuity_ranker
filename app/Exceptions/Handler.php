<?php

namespace App\Exceptions;

use Exception;
use App\Models as Models;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {

        // SCRF TOKEN TIMEOUT
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->json(['reason' => 'token_timeout', 'new_token' => csrf_token()], 200);
        }

        if($this->isHttpException($exception)){
            if ($exception->getStatusCode() !== 200) {
                return response()->make(view('errors.404', []), 404);
                return redirect()->route('404');
            }
        }
        return parent::render($request, $exception);
    }
}
