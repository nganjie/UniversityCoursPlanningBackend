<?php

use App\Http\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $exception,  $request) {
        if ($request->is('api/*')) {
             $status = 500;
    $message = 'Erreur serveur';
    $errors = [];

    if ($exception instanceof AuthenticationException) {
        $status = 401;
        $message = 'Non authentifié';
    } elseif ($exception instanceof ValidationException) {
        $status = 422;
        $message = 'Erreur de validation';
        $messages = collect($exception->errors())->map(function ($messages, $field) {
        return $field . ' : ' . implode(' ', $messages);
    })->implode(' '); // Join tout en une seule phrase

    $message = $messages;

        $errors = $exception->errors();
    } elseif ($exception instanceof ModelNotFoundException) {
        $status = 404;
        $message = 'Ressource non trouvée';
    } elseif ($exception instanceof NotFoundHttpException) {
        $status = 404;
        $message = 'Route non trouvée';
    } elseif ($exception instanceof MethodNotAllowedHttpException) {
        $status = 405;
        $message = 'Méthode HTTP non autorisée';
    } elseif ($exception instanceof HttpException) {
        $status = $exception->getStatusCode();
        $message = $exception->getMessage() ?: 'Erreur HTTP';
    } else {
        // Log optionnel pour les erreurs inconnues
        logger()->error($exception);
        $message = $exception->getMessage() ?: $message;
    }

   /* return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors,
        'status_code'=>$status
    ], $status);*/
    return ApiResponse::exception($message, $errors,$status);
        }
    });
    })->create();
