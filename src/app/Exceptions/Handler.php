<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Auth\Access\AuthorizationException;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        /**
         * if request is API(has header of Application/json)
         */
        if ($request->wantsJson()) {
            /**
             * laravel unAuthorizedHttException handler
             */
            if ($e instanceof AuthorizationException) {
                return (new BaseApiController())
                    ->returnError(
                        __('shared::unAuthorizedException.unAuthorizedExceptionMessage'),
                        null,
                        403
                    );
            }

            /**
             * laravel formRequests error handler
             */
            if ($e instanceof ValidationException) {
                return (new BaseApiController())
                    ->returnError(
                        __('shared::invalid_data.invalid_data'),
                        $e->errors(),
                        500
                    );
            }

            /**
             * other customized exception handler
             */
            if ($e instanceof BaseApiException) {
                return (new BaseApiController())->returnError(
                    $e->getMessage(),
                    [],
                    $e->getErrorCode()
                );
            }


        }

        return parent::render($request, $e);
    }

}
