<?php

namespace App\Exceptions;

use Exception;

class ExceptionHandler extends Exception
{
     public function render(){
        $this->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Not authenticated'
                ], 401);
            }
        });
    }
}
