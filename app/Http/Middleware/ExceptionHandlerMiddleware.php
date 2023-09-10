<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;

class ExceptionHandlerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro interno no servidor.'], 500);
        }
    }
}