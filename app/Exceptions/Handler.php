<?php

/**
* Description:
* Handler class (inherited from base ExceptionHandler)
* 
* List of methods:
* - report(Throwable $exception) | Report or log an exception
* - render($request, Throwable $exception) | Render an exception into an HTTP response
*/

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\ErrorLog;
use Illuminate\Validation\ValidationException;

use App\ApiCall;
use App\Setting;

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
    * Description:
    * Report or log an exception
    *
    * List of parameters:
    * - $exception : Throwable  
    * 
    * Return:
    * void
    */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
    * Description:
    * Render an exception into an HTTP response
    *
    * List of parameters:
    * - $request : Request
    * - $exception : Throwable
    *
    * Return:
    * view content
    */
    public function render($request, Throwable $exception)
    {
      $data = [
        'url' => $request->getRequestUri(),
        'method' => $request->getMethod(),
        'error' => $exception->getMessage(),
      ];
      $log = ErrorLog::log($data);
      if ($exception instanceof ValidationException) {
        return redirect('/login')
          ->withInput($request->only("email", 'remember'))
          ->withErrors(["email" => \Lang::get('auth.failed')]);
      }

      if ($exception instanceof TokenMismatchException) {
           if ($request->getRequestUri()==='/logout') {
             auth()->logout();
             return redirect('/');
          }
        }

        // show maintenance mode page
        if (method_exists('getStatusCode', $exception) && $exception->getStatusCode() == 503) {
            return response()
            ->view('maintenance-mode', [
                'message' => Setting::getMaintenanceMessage()
            ]);
    }

        return parent::render($request, $exception);
    }
}
