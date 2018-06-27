<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ErrorException;


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
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($request->expectsJson()){
            if ($exception instanceof ErrorException) {
                return response()->json([
                    'errors' => 'There is an error.This item does not exist.'
                ], Response::HTTP_NOT_FOUND);
            }
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'errors' => 'There is an error. Model not found.'
                ], Response::HTTP_NOT_FOUND);
            }
            
           if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'errors' => 'There is an error. Incorrect route.'
                ], Response::HTTP_NOT_FOUND);
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'errors' => 'There is an error. Incorrect method sent to route.'
                ], Response::HTTP_NOT_FOUND);
            }


        }


        return parent::render($request, $exception);
    }
}
