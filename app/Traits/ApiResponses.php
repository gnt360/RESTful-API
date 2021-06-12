<?php

namespace App\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait ApiResponses
{
    protected function successResponse( $message = null, $data = null, $statusCode = 200)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ])->setStatusCode($statusCode);
    }

    protected function createdResponse( $message = null, $data = null, $statusCode = 201)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'created',
            'message' => $message,
            'data' => $data,
        ])->setStatusCode($statusCode);
    }

    protected function notFoundResponse( $message = null, $statusCode = 404)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'not_found',
            'message' => $message,
        ])->setStatusCode($statusCode);
    }

    protected function unauthenticatedResponse( $message = null, $statusCode = 401)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'unauthenticated',
            'message' => $message,
        ])->setStatusCode($statusCode);
    }

    protected function formValidationResponse($errors, $statusCode = 422)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'validation_error',
            'message' => 'validation_error',
            'validationErrors' => $errors,
        ])->setStatusCode($statusCode);
    }

    protected function validationResponse($errors, $statusCode = 422)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'validation_error',
            'message' => 'validation_error',
            'validationErrors' => $errors,
        ])->setStatusCode($statusCode);
    }

    protected function noContentResponse( $message = null, $statusCode = 204)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'no_content',
            'message' => $message,
        ])->setStatusCode($statusCode);
    }

    protected function badRequestResponse( $message = null, $data = null, $statusCode = 400)
    {
        return response([
            'statusCode' => $statusCode,
            'status' => 'bad_request',
            'message' => $message,
            'data' => $data,
        ])->setStatusCode($statusCode);
    }

    

}