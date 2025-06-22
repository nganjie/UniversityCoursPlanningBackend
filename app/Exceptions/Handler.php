<?php 
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends Exception
{
     public function render($request, Throwable $exception)
{
    // Si c’est une requête API (par exemple avec le header Accept: application/json)
    if ($request->expectsJson()) {
        return $this->handleApiException($request, $exception);
    }

    // Sinon, comportement normal (HTML, etc.)
    return parent::render($request, $exception);
}
protected function handleApiException($request, Throwable $exception)
{
    // Par défaut
    $status = 500;
    $message = 'Erreur serveur';
    $errors = [];

    if ($exception instanceof AuthenticationException) {
        $status = 401;
        $message = 'Non authentifié';
    } elseif ($exception instanceof ValidationException) {
        $status = 422;
        $message = 'Erreur de validation';
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

    return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], $status);
}

}

