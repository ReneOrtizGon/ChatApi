<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->descriptiveResponseMethods();
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        Response::macro('ok', function ($data = '') {
            return Response::json( $data, 200);
        });

        Response::macro('ok_data', function ($data = []) {

            return Response::json(['data' => $data], 200);
        });

        Response::macro('ok_array', function ($data = []) {

            return Response::json($data, 200);
        });

        Response::macro('ok_message', function ($message) {

            return Response::json(["message"=>$message], 200);
        });

        Response::macro('created', function ($data = []) {
            if (count($data)) {
                return Response::json(['data' => $data], 201);
            }

            return Response::created();
        });

        Response::macro('noContent', function () {
            return Response::noContent();
        });

        Response::macro('badRequest', function ($message = 'Validation Failure', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 400);
        });

        Response::macro('unauthorized', function ($message = 'User unauthorized', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 401);
        });

        Response::macro('forbidden', function ($message = 'Access denied', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 403);

        });

        Response::macro('notFound', function ($message = 'Resource not found.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 404);
        });

        Response::macro('internalServerError', function ($message = 'Internal Server Error.', $errors = []) use ($instance) {
            return $instance->handleErrorResponse($message, $errors, 500);
        });
    }

    public function handleErrorResponse($message, $errors, $status)
    {
        $response = [
            'message' => $message,
        ];

        if (is_countable($errors) && count($errors)) {
            $response['errors'] = $errors;
        } else {
            $response['error'] = $errors;
        }

        return Response::json($response, $status);
    }
}
