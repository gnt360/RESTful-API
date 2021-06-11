<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
     * @param Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
         if ($exception instanceof ValidationException) {
             return $this->convertValidationExceptionToResponse($exception, $request);
         }
         if ($exception instanceof ModelNotFoundException) {
             $model = strtolower(class_basename($exception->getModel())) ;
             return $this->errorResponse("{$model} with the specified id does not exist", 404);
         }
         if ($exception instanceof MethodNotAllowedHttpException) {
             return $this->errorResponse('The specified method for the request is invalid',405);
         }
         if ($exception instanceof NotFoundHttpException) {
             return $this->errorResponse("The specified URL does not exist", 404);
         }
         if ($exception instanceof HttpException) {
             return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
         }
         if ($exception instanceof QueryException) {
             $errorCode = $exception->errorInfo[1];
             if ($errorCode == 1451) {
                 return $this->errorResponse("Sorry, you cannot delete this resource permanently because it is related to other resources", 409);
             }
         }

        return parent::render($request, $exception);
    }

    /**
     * a generic method for all error
     * messages
     * @param $message
     * @param int $statusCode
     * @return Application|ResponseFactory|\Illuminate\Http\Response|object
     */
    protected function errorResponse($message, $statusCode = 500)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'error',
            'message' => $message
        ])->setStatusCode($statusCode);
    }
}