<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {
	use ApiResponser;

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		AuthorizationException::class,
		HttpException::class,
		ModelNotFoundException::class,
		ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
	 * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
	 */
	public function render($request, Exception $exception) {

		if ($exception instanceOf HttpException) {
			$code = $exception->getStatusCode();
			$message = Response::$statusTexts[$code];

			return $this->errorResponse($message, $code);
		}

		if ($exception instanceOf ModelNotFoundException) {
			$model = strtolower(class_basename($exception->getModel()));

			return $this->errorResponse("No se encontro una instancia para el {$model} especificado", Response::HTTP_NOT_FOUND);
		}

		if ($exception instanceOf AuthorizationException) {
			return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
		}

		if ($exception instanceOf AuthenticationException) {
			return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
		}

		if ($exception instanceOf ValidationException) {
			$errors = $exception->validator->errors()->getMessages();

			return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
		}

		if ($exception instanceOf ClientException) {
			$message = $exception->getResponse()->getBody();
			$code = $exception->getCode();

			return $this->errorMessage($message, $code);
		}

		if (env('APP_DEBUG', false)) {
			return parent::render($request, $exception);
		}

		return $this->errorResponse('Erro inesperado, intente mas tarde', Response::HTTP_INTERNAL_SERVER_ERROR);
	}
}
