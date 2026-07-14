<?php

namespace App\Exceptions;

use App\Mail\Internal\ReportRequestError;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        try {
            parent::report($exception);
        } catch (Throwable $throwableToIgnore) {
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        try {
            if (!($e instanceof NotFoundHttpException)) {
                Mail::send(new ReportRequestError(url()->current(), $request, $e));
            }
        } catch (Throwable $throwableToIgnore) {
        }

        if ($request->wantsJson()) {
//            $this->prepareException($e);
            if ($e instanceof TokenMismatchException) {
                return response()->json([ 'message' => 'No Auth'], 419);
            }
            return parent::render($request, $e);
        }
        if ($e instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect()->route('home.es')->setStatusCode(301);
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            return redirect()->route('home.es')->setStatusCode(301);
        }
        if ($e instanceof DecryptException || $e instanceof DataTokenReviewException) {
            return parent::render($request, $e);
        }
        if ($this->isHttpException($e)) {
            switch (intval($e->getStatusCode())) {
                case 500:
                    return redirect()->route('home.es')->setStatusCode(500);
                case 404:
                    return redirect()->route('home.es')->setStatusCode(404);
                default:
                    return $this->renderHttpException($e);
            }
        }
        if (        $request->getPathInfo() === "/password/reset" ||
            $request->getPathInfo() === "/es/contacto"
        ) {
            if ($e instanceof ValidationException) {
                return parent::render($request, $e);
            }
        }
        if (
        $request->getPathInfo() === "/api/stripe/webhooks" ||
            $request->getPathInfo() === "/api/stripe/webhooks/invoices" ||
            $request->getPathInfo() === "/api/stripe/webhooks/payment-intents"
        ) {
            try {
                return parent::render($request, $e);
            } catch (Throwable $throwableToIgnore) {
            }
        }
        if (env('APP_ENV') !== 'production' && env('APP_ENV') !== 'preproduction') {
            dd($e instanceof ValidationException, $this->isHttpException($e), $request->getPathInfo(), $request->wantsJson(), $request, $e, url()->current(), $request->path());
        }
        return redirect()->route('home.es')->setStatusCode(301);
    }
    protected function prepareException(Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        } elseif ($e instanceof AuthorizationException) {
            $e = new AccessDeniedHttpException($e->getMessage(), $e);
        } elseif ($e instanceof TokenMismatchException) {
            $e = new HttpException(419, $e->getMessage(), $e);
        } elseif ($e instanceof SuspiciousOperationException) {
            $e = new NotFoundHttpException('Bad hostname provided.', $e);
        } elseif ($e instanceof RecordsNotFoundException) {
            $e = new NotFoundHttpException('Not found.', $e);
        }

        return parent::prepareException($e);
    }
}
